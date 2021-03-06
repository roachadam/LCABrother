@extends('layouts.theme')
@section('title', 'Set Rules for Academic Standings')
@section('content')
    <div class="auth__media">
        <img src="/img/home/forum.svg">
    </div>
    <div class="auth__auth">
        <h1 class="auth__title">Set Rules for Academic Standings</h1>

        @if ($academicStandings->isNotEmpty())
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Term GPA Min</th>
                    <th>Cumulative GPA Min</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($academicStandings as $academicStanding)
                        <tr>
                            <td>{{ $academicStanding->name }}</td>
                            <td>{{ $academicStanding->Term_GPA_Min }}</td>
                            <td>{{ $academicStanding->Cumulative_GPA_Min }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @include('partials.errors')
        {{-- <label><b><u>Want to have an example they can look at in a modal or something but the style sheets and scripts arent inported and when I try to import them it doesn't work</u></b></label> --}}
        <form method="POST" action="/academicStandings" name="setAcademicStadningsForm" id="setAcademicStadningsForm">
            @csrf

            <label>Name of Category</label>
            <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autofocus>

            @if($academicStandings->isNotEmpty())
                <div class="checkbox-toggle form-group">
                    <input type="checkbox" value="worstStanding" name="worstStanding" id="worstStanding" onclick="toggleGPAs()">
                    <label for="worstStanding">Worst Standing?</label>
                </div>
            @endif

            <div class="form-group" id="GPAs">
                <label>Current Term Gpa Min</label>
                <input id="Term_GPA_Min" type="text" class="form-control " name="Term_GPA_Min" value="{{ old('Term_GPA_Min') }}" required autofocus>

                <label>Cumulative Term Gpa Min</label>
                <input id="Cumulative_GPA_Min" type="text" class="form-control " name="Cumulative_GPA_Min" value="{{ old('Cumulative_GPA_Min') }}" required autofocus>

                <input type="hidden" name="SubmitAndFinishCheck" id="SubmitAndFinishCheck" value="0">
                <input type="hidden" name="lowest" id="lowest" value="0">
            </div>
            <button type="submit" class="button button__primary" id="submit">Submit</button>
            <a href="/dash" class="button" id="nextButton">Next</a>
            <button type="submit" class="button button__primary" id="submitAndFinish" style="display: none" onclick="SubmitAndFinish()">Submit and Finish</button>
        </form>
    </div>


    <script>
        function toggleGPAs(){
            if(document.getElementById('worstStanding').checked){
                document.getElementById('GPAs').style.display = "none";
                document.getElementById('submit').style.display = "none";
                document.getElementById('nextButton').style.display = "none";
                document.getElementById('submitAndFinish').style.display = "";

                document.getElementById("lowest").value = "1";
                document.getElementById("Cumulative_GPA_Min").value = 0;
                document.getElementById("Term_GPA_Min").value = 0;
            } else {
                document.getElementById('GPAs').style.display = "block";
                document.getElementById('submit').style.display = "";
                document.getElementById('nextButton').style.display = "";
                document.getElementById('submitAndFinish').style.display = "none";

                document.getElementById("lowest").value = "1";
                document.getElementById("Cumulative_GPA_Min").value = null;
                document.getElementById("Term_GPA_Min").value = null;
            }
        }

        function SubmitAndFinish() {
            document.getElementById("SubmitAndFinishCheck").value = "1";
        }
    </script>
@endsection
