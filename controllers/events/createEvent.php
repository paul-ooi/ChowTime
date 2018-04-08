<?php include '../../pages/partial/_header.php'; ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<main class="wrapper">
<div class="row">
    <h1>Create Event</h1>
</div>
<form method="post" action="#" class="form-horizontal">
    <div class="form-group row">
        <label for="eName" class="col-sm-2 text-right control-label">Event Name*</label>
        <div class="col-sm-10">
            <input type="text" name="eName" id="eName" class="form-control" placeholder="What is this event called?" />
        </div>
    </div>
    <div class="form-group row">
        <label for="eLoc" class="col-sm-2 text-right control-label"><i class="fas fa-map-marker"></i> Location*</label>
        <div class="col-sm-10">
            <input type="text" name="eLoc" id="eLoc" class="form-control" placeholder="Include place or address." />
        </div>
    </div>
    <div class="form-group row">
        <label for="eDate" class="col-sm-2 text-right control-label"><i class="far fa-calendar-alt"></i> Date*</label>
        <div class="col-sm-10">
            <input type="text" id="datepicker" />
        </div>
    </div>
    <div class="form-group row">
        <label for="eStartTime" class="col-sm-2 text-right control-label"><i class="far fa-clock"></i> Start Time*</label>
        <div class="col-sm-10">
            <select class="timeSelect">
                <option value="none">Choose a time...</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="eEndTime" class="col-sm-2 text-right control-label"><i class="far fa-clock"></i> End Time</label>
        <div class="col-sm-10">
            <select class="timeSelect">
                <option value="none">Choose a time...</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="eDescription" class="col-sm-2 text-right control-label">Description*</label>
        <div class="col-sm-10">
            <textarea id="eDescription" class="form-control" rows="3" placeholder="A little something about your event."></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="ePrivacy" class="col-sm-2 text-right control-label"><i class="fas fa-unlock"></i> Privacy*</label>
        <div class="col-sm-10">
            <input type="radio" name="ePrivacy" value="private" id="privatePrivacy" /><label for="privatePrivacy"> Private </label>
            <input type="radio" name="ePrivacy" value="public" id="publicPrivacy" /><label for="publicPrivacy"> Public </label>
        </div>
    </div>
    <div class="form-group row">
        <label for="eTheme" class="col-sm-2 text-right control-label">Theme</label>
        <div class="col-sm-10">
            <input type="text" id="eTheme" class="form-control" placeholder="Is there a theme?"/>
        </div>
    </div>
    <div class="form-group row">
        <div class="ml-auto">
            <div class="btn-group" role="group" aria-label="...">
                <form action="" method="post" name="createEvent">
                    <input type="submit" class="btn btn-default" value="Create Event" />
                </form>
                <button class="btn btn-default">Cancel</button>
            <div>
        </div>
    </div>
</form>
</main>
<script src="../../assets/js/jqueryui/external/jquery/jquery.js"></script>
<script src="../../assets/js/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="../../assets/js/jquery-timepicker/jquery.timepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../../assets/js/events.js"></script>
<?php include '../../pages/partial/_footer.php'; ?>
