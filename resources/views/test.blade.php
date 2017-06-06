@extends('layouts.master')

@section('content')
    <div class="space-40"></div>

    <div id="root">


        <select v-model="selected" name="currency" >
            <option value="0">--Währung wählen</option>
            <optgroup>
                <option v-for="currency in currencies" :value="currency">@{{ currency }}</option>
            </optgroup>
        </select>
        <br>
        Selected value is : @{{ selected }}
    </div>

    <div class="space-40"></div>
@endsection


@section('scripts.footer')
<script>
    new Vue({
        el: '#root',
        data: {
            selected: '',
            currencies: ['EUR', 'USD', 'CHF']
        }
    })



</script>
@endsection