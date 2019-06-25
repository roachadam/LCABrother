@extends('layouts.theme')
@section('title', 'Set Academic Rules')
@section('content')
    <div class="auth__media">
        <img src="/img/home/forum.svg">
    </div>
    <div class="auth__auth">
        <h1 class="auth__title">Set Academic Rules</h1>

        @forelse ($academicStandings as $academicStanding)
            <div class="row offset-1">
                <ol>
                {{ $academicStanding->name}}
                </ol>
            </div>
        @empty
        TODO: Add default option for the lowest possible standing for every submission after the first
        @endforelse

        @include('partials.errors')
        <label>Describe what to do, thanks adam.</label>
        <form method="POST" action="/academicStandings">
            @csrf

            <label>Name of Category</label>
            <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autofocus>

            <div class="checkbox-toggle form-group">
                <input type="checkbox" value="worstStanding" name="worstStanding" id="worstStanding" onclick="toggleGPAs()">
                <label for="worstStanding">Worst</label>
            </div>

            <div class="form-group" id="GPAs" style="display: true">
                <label>Cum Term Gpa Min</label>
                <input id="Cumulative_GPA_Min" type="text" class="form-control " name="Cumulative_GPA_Min" value="{{ old('Cumulative_GPA_Min') }}" required autofocus>

                <label>Current Term Gpa Min</label>
                <input id="Term_GPA_Min" type="text" class="form-control " name="Term_GPA_Min" value="{{ old('Term_GPA_Min') }}" required autofocus>
            </div>

            <button type="submit" class="button button__primary">Submit</button>
            <a href="/dash" class="button">Next</a>
        </form>
    </div>

    <script>
        function toggleGPAs(){
            if(document.getElementById('worstStanding').checked){
                let div = document.getElementById('GPAs');
                div.style.display = "none";
                document.getElementById("Cumulative_GPA_Min").value = 0;
                document.getElementById("Term_GPA_Min").value = 0;
            } else {
                let div = document.getElementById('GPAs');
                div.style.display = "block";
                document.getElementById("Cumulative_GPA_Min").value = null;
                document.getElementById("Term_GPA_Min").value = null;
            }
        }
    </script>
@endsection
