<h2>Phase ändern</h2>
<select id="change-phase-input" class="noinput" style="background-color: var(--color-standard-card); color: var(--color-standard-white); padding: 7px; border-radius: 4px">
    <option data-option="add_users">Add Users</option>
    <option data-option="poll">Abstimmung</option>
    <option data-option="results">Ergebnisse</option>
</select>
<div class="buttons" style="display: flex; align-items: center; margin-top: 25px">
    <button class="submit-button" style="width: unset!important; margin-top: 0; font-size: 0.9rem" id="change-phase-submit">Ändern</button>
    <a href="/admin" style="color: var(--bs-link-color); margin-left: 8px; font-size: 0.87rem" class="pointer">Zurück</a>
</div>
<script>
    $(function () {
        $("#change-phase-submit").click(function() {
            phase = $($("#change-phase-input").get(0).selectedOptions[0]).attr("data-option");
            $.post("/ajax/admin/change_phase.php", {phase: phase},
                function (data, textStatus, jqXHR) {
                    toast_json_answer(data);
                }
            );
        })
    });
</script>