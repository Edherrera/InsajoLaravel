<div class="table-responsive">
    <table class="table" id="activities-table">
        <thead>
            <tr>
                <th onclick="sortTable(0, 'str')">Clase</th>
                <th onclick="sortTable(1, 'str')">Estado</th>
                <th onclick="sortTable(2, 'str')">Nombre</th>
                <th onclick="sortTable(3, 'str')">Descripción</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th onclick="sortTable(6, 'str')">Material</th>
                <th onclick="sortTable(7, 'str')">Enlace</th>
                <th colspan="3">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->teacher->class_name ?? 'Ninguno' }}</td>
                    <td>{{ $activity->status }}</td>
                    <td>{{ $activity->name }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->since }}</td>
                    <td>{{ $activity->deadline }}</td>
                    <td><a
                            href="{{ route('activities.download', $activity->uuid) }}">{{ $activity->homework }}</a>{{-- {{ $activity->homework }} --}}
                    </td>
                    <td>{{ $activity->url }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['activities.destroy', $activity->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            @can('activities.show')
                                <a href="{{ route('activities.show', [$activity->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                            @endcan
                            @can('activities.edit')
                                <a href="{{ route('activities.edit', [$activity->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                            @endcan
                            @can('activities.destroy')
                                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('Está seguro?')",
                                ]) !!}
                            @endcan
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    /**
     * Funcion para ordenar una tabla... tiene que recibir el numero de columna a
     * ordenar y el tipo de orden
     * @param int n
     * @param str type - ['str'|'int']
     */
    function sortTable(n, type) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;

        table = document.getElementById("activities-table");
        switching = true;
        //Set the sorting direction to ascending:
        dir = "asc";

        /*Make a loop that will continue until no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /*Loop through all table rows (except the first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare, one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place, based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if ((type == "str" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) || (type == "int" &&
                            parseFloat(x.innerHTML) > parseFloat(y.innerHTML))) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if ((type == "str" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) || (type == "int" &&
                            parseFloat(x.innerHTML) < parseFloat(y.innerHTML))) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>
