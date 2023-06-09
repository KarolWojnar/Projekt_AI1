<div id="formHide" style="display: block;" class="bg-dark rounded">
    <div class="text-white">
        <a href="" class="btn btn-danger2 btn-block" id="reportBtn" onclick="toggleSupportPanel(event)">Zgłoś problem</a>
    </div>
    <li id="edit-panel" class="card list-group-item text-white edit-panel mx-auto  rounded border border-3 border-danger" style="display: none;">
        <form id="supportForm" action="{{ route('addProblem') }}" method="POST">
            @csrf
            <div class="form-group m-2">
                <label for="email">Podaj swój email:</label>
                <input type="email" required class="form-control bg-dark2 text-white" id="email" name="email" value="{{ old('email') }}">
                <span class="text-danger" id="emailError"></span>
            </div>

            <div class="form-group m-2">
                <label for="typeOf">Wybierz rodzaj problemu:</label>
                <select required class="form-control bg-dark2 text-white" id="typeOf" name="typeOf">
                    <option value="">Wybierz</option>
                    <option value="wypożyczenia">Wypożyczenia</option>
                    <option value="rejestracja">Rejestracja</option>
                    <option value="płatność">Płatność</option>
                    <option value="edycja danych">Edycja danych</option>
                    <option value="wyświetlanie strony">Wyświetlanie strony</option>
                </select>
                <span class="text-danger" id="typeOfError"></span>
            </div>

            <div class="form-group m-2">
                <label for="problem">Zgłoś problem:</label>
                <textarea required class="form-control bg-dark2 text-white" id="problem" name="problem" rows="5">{{ old('problem') }}</textarea>
                <span class="text-danger" id="problemError"></span>
            </div>

            <div class="form-group" style="float: right">
                <button type="submit" class="btn btn-secondary custom-btn m-2 w-30" onclick="submitForm(event)">Wyślij</button>
                <button type="button" class="btn btn-secondary custom-btn m-2 w-30" id="goback" onclick="toggleSupportPanel2(event)">Anuluj</button>
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
