<h3>Nutzer hinzufügen</h3>
<form onsubmit="add_user_submit(); return false;">
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
    <div class="input-group" style="width: unset!important; padding-top: 0">
        <div class="input-container">
            <img src="/images/school.svg" class="icon" alt="">
            <input class="noinput" id="add-user-class" type="text" placeholder="Klasse">
        </div>
    </div>
    <div id="password" style="display: none;">
        
    </div>
    <div class="buttons" style="display: flex; align-items: center; justify-content: center; margin-top: 12px">
        <button class="submit-button" style="width: unset!important; margin-top: 0" id="add-user-submit">Hinzufügen</button>
        <a href="/admin" style="color: var(--bs-link-color); margin-left: 8px; font-size: 0.9rem" class="pointer">Zurück</a>
    </div>
</form>
<script>

    function add_user_submit() {
        username = $("#add-user-username").val();
        firstname = $("#add-user-firstname").val();
        lastname = $("#add-user-lastname").val();
        class_val = $("#add-user-class").val();
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
                lastname: lastname,
                class: class_val
            },
            function (data, textStatus, jqXHR) {
                toast_json_answer(data);
                $("#password").text("Passwort: "+JSON.parse(data).info.password);
                $("#password").show();
                changed_username = false;
            }
        );
    }

    var changed_username = false;
    $(function () {
        $("#add-user-submit").click(function() {
            
        })

        $("#add-user-username").keyup(function() {
            changed_username = $("#add-user-username").val().length > 0
        })

        $("#add-user-firstname").keyup(function() {
            if(changed_username) return;
            new_val = ""
            if($("#add-user-firstname").val().length <= 0) new_val = $("#add-user-lastname").val()
            else if($("#add-user-lastname").val().length <= 0) new_val = $("#add-user-firstname").val()
            else new_val = $("#add-user-firstname").val() + "." + $("#add-user-lastname").val()
            $("#add-user-username").val(new_val)
        })

        $("#add-user-lastname").keyup(function() {
            if(changed_username) return;
            new_val = ""
            if($("#add-user-firstname").val().length <= 0) new_val = $("#add-user-lastname").val()
            else if($("#add-user-lastname").val().length <= 0) new_val = $("#add-user-firstname").val()
            else new_val = $("#add-user-firstname").val() + "." + $("#add-user-lastname").val()
            $("#add-user-username").val(new_val)
        })
    });
</script>