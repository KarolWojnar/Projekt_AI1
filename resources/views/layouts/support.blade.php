<div id="formHide" style="display: block;">
    <div class="text-white mx-auto">
        <a class="btn btn-danger" id="reportBtn" onclick="toggleSupportPanel(event)">Zgłoś problem</a>
    </div>
        <li id="edit-panel" class="card list-group-item text-white edit-panel mx-auto bg-dark" style="display: none;">

            <form action="" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="address">Podaj swój email: </label>
                    <input type="text" class="form-control bg-dark2 text-white" id="address" name="address" value="">
                </div>
                <div class="form-group">
                    <label for="problem">Zgłoś problem</label>
                    <input type="text" class="form-control bg-dark2  text-white" id="problem" name="problem" value="" style="height: 20rem; width: 19rem; vertical-align: top;">
                </div>
                <div class="" style="float: right">
                    <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Wyślij</button>
                    <button type="button"  class="btn btn-secondary custom-btn m-2 w-30" id="goback" onclick="toggleSupportPanel2(event)">Anuluj</button>
                </div>
            </form>
        </li>
    </div>
<script>
    function toggleSupportPanel(event) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel');
        if (editPanel.style.display === 'none') {
            editPanel.style.display = 'block';
            document.getElementById('reportBtn').style.display = 'none';
        } else {
            editPanel.style.display = 'none';
        }
    }
    function toggleSupportPanel2(event) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel');
        editPanel.style.display = 'block';
        document.getElementById('reportBtn').style.display = 'block';
        editPanel.style.display = 'none';
    }
</script>
