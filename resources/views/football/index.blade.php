
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
<h1>Football Matches Filter</h1>

    <form id="filterForm">
        <label>Competition:
            <select name="competition" id="competition">
                <option value="">-- All --</option>
                <option value="PL">Premier League</option>
                <option value="CL">Champions League</option>
                <option value="SA">Serie A</option>
                <option value="BL1">Bundesliga</option>
                <option value="FL1">Ligue 1</option>
            </select>
        </label>

        <label>Status:
            <select name="status" id="status">
                <option value="">-- All --</option>
                <option value="SCHEDULED">Scheduled</option>
                <option value="LIVE">Live</option>
                <option value="FINISHED">Finished</option>
                <option value="POSTPONED">Postponed</option>
            </select>
        </label>

        <button type="submit">Filter</button>
    </form>

    <hr>

    <div id="results">
        <table id="matchesTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Competition</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Status</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6">Please apply filter and click "Filter" button</td></tr>
            </tbody>
        </table>
        <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const competition = $('#competition').val();
                const status = $('#status').val();

                $.ajax({
                    url: "{{ route('football.matches') }}",
                    method: 'GET',
                    data: { competition, status },
                    success: function(data) {
                        let rows = '';

                        if(data.matches && data.matches.length > 0) {
                            data.matches.forEach(match => {
                                const date = new Date(match.utcDate).toLocaleString();
                                const competitionName = match.competition.name;
                                const homeTeam = match.homeTeam.name;
                                const awayTeam = match.awayTeam.name;
                                const status = match.status;
                                const score = (match.score.fullTime.home !== null && match.score.fullTime.away !== null) ?
                                              `${match.score.fullTime.home} - ${match.score.fullTime.away}` : 'N/A';

                                rows += `<tr>
                                    <td>${date}</td>
                                    <td>${competitionName}</td>
                                    <td>${homeTeam}</td>
                                    <td>${awayTeam}</td>
                                    <td>${status}</td>
                                    <td>${score}</td>
                                </tr>`;
                            });
                        } else {
                            rows = `<tr><td colspan="6">No matches found for selected filters.</td></tr>`;
                        }

                        $('#matchesTable tbody').html(rows);
                    },
                    error: function() {
                        $('#matchesTable tbody').html('<tr><td colspan="6">Error fetching data from API.</td></tr>');
                    }
                });
            });
        });
    </script>
@endsection
