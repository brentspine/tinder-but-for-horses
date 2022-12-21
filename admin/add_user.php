<h3>Nutzer hinzufügen</h3>
<div class="input-group" style="width: unset!important;">
    <div class="input-container">
        <img src="/images/edit.svg" class="icon" alt="">
        <input class="noinput" id="add-user-username" type="text" placeholder="Nutzername">
    </div>
</div>
<div class="input-group" style="width: unset!important; padding-top: 0">
    <div class="input-container">
        <img src="/images/user.svg" class="icon" alt="">
        <input class="noinput" id="add-user-firstname" type="text" placeholder="Vorname">
    </div>
</div>
<div class="input-group" style="width: unset!important; padding-top: 0">
    <div class="input-container">
        <img src="/images/user.svg" class="icon" alt="">
        <input class="noinput" id="add-user-lastname" type="text" placeholder="Nachname">
    </div>
</div>
<div id="password" style="display: none;">
    
</div>
<div class="buttons" style="display: flex; align-items: center; margin-top: 12px">
    <button class="submit-button" style="width: unset!important; margin-top: 0" id="add-user-submit">Hinzufügen</button>
    <a href="/admin" style="color: var(--bs-link-color); margin-left: 8px; font-size: 0.9rem" class="pointer">Zurück</a>
</div>
<script>
    $(function () {
        $("#add-user-submit").click(function() {
            username = $("#add-user-username").val();
            firstname = $("#add-user-firstname").val();
            lastname = $("#add-user-lastname").val();
            if(firstname.length < 2 || lastname.length < 2) {
                show_toast("Name zu kurz", "var(--color-standard-error-text)", 2000, true);
                return;
            }
            if(username.length < 3) {
                show_toast("Nutzername zu kurz", "var(--color-standard-error-text)", 2000, true);
                return;
            }
            $.post("/ajax/admin/create_user.php", 
                {
                    username: username,
                    firstname: firstname,
                    lastname: lastname
                },
                function (data, textStatus, jqXHR) {
                    toast_json_answer(data);
                    $("#password").text("Password: "+JSON.parse(data).info.password);
                    $("#password").show();
                }
            );
        })
    });
</script>