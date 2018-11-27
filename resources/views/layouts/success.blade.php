@if (isset($success) && count($success))
    <div class="form-group">
        <div class="alert alert-success">
            <ul>
<?php       if (gettype($success)=="object") {   ?>
                @foreach ($success->all() as $row)
                    <li>{{ $row }}</li>
                @endforeach
<?php       }
            if (gettype($success)=="array")  {   ?>
                @foreach ($success as $row)
                    <li>{{ $row }}</li>
                @endforeach
<?php       } 
            if (gettype($success)=="string") {   ?>
                    <li>{{ $success }}</li>
<?php       }   ?>
            </ul>
        </div>
    </div>
@endif
