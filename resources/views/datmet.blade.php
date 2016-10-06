
<form method="GET" action="{{ url('getblank') }}">
    <select name="id_met">
        <option disabled>Выберите собрание</option>
        @foreach($mets as $meet))
        @if (( $meet->date_end > date('Y-m-d H:i:s')) && ($meet->date_start <= date('Y-m-d H:i:s')))
            <option value={{$meet->id_meeting}}> с {{date_create($meet->date_start)->format('d-m-Y')}} по {{date_create($meet->date_end)->format('d-m-Y')}}</option>
            @endif
        @endforeach
    </select>
    <input type='submit' value='Получить бланк'/>
</form>