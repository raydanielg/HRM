<div class="btn-group btn-group-sm">
    <a href="{{ route("admin.employees.edit", $employee->employeeID) }}" class="btn yellow-casablanca"><i class="fa fa-edit"></i>  View/Edit</a>
    <button type="button" class="btn yellow-casablanca dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true" aria-expanded="false">
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li>
            <a href="javascript:;" onclick='del("{{ addslashes($employee->employeeID) }}", "{{ addslashes($employee->full_name) }}")'><i class="fa fa-trash"></i>  Delete </a>
        </li>
    </ul>
</div>
