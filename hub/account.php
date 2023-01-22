<style>
    @media(max-width: 500px) {
        .account .input-group {
            flex-flow: column;
        }
        .account .input-group-item {
            padding-top: .7rem;
        }
    }
</style>
<script>
    function on_account_settings_save(e) {
        var bio = $("#bio-update-input").val();   
        //var lines = bio.split(/\r|\r\n|\n/).length;
        $.post("/ajax/account/change_account.php", {bio: bio, class: "1"},
            function (data, textStatus, jqXHR) {
                toast_json_answer(data);
            }
        );
        return false;
    }

</script>
<div class="account">
    <h3>Account Settings</h3>
    <form action="" onsubmit="return on_account_settings_save(event)">
        <div class="input-group">
            <div class="input-group-item">
                <div class="label">
                    <label for="username">Nutzername</label>   
                </div>
                <div class="input-container">
                    <img src="/images/user.svg" class="icon" alt="O">
                    <input style="cursor: not-allowed;" class="noinput" name="username" type="text" placeholder="Nutzername" readonly value="<?php echo get_database_entry_result(prepared_statement_result("SELECT username FROM users WHERE id = ?", $con, true, "s", $uid), "username")?>">
                </div>
            </div>
        </div>
        <div class="input-group">
            <div class="input-group-item">
                <div class="label">
                    <label for="firstname">Vorname</label>   
                </div>
                <div class="input-container">
                    <img src="/images/user.svg" class="icon" alt="O">
                    <input style="cursor: not-allowed;" class="noinput" name="firstname" type="text" placeholder="Vorname" readonly value="<?php echo get_database_entry_result(prepared_statement_result("SELECT first_name FROM users WHERE id = ?", $con, true, "s", $uid), "first_name")?>">
                </div>
            </div>

            <div class="input-group-item">
                <div class="label">
                    <label for="lastname">Nachname</label>   
                </div>
                <div class="input-container">
                    <img src="/images/user.svg" class="icon" alt="O">
                    <input style="cursor: not-allowed;" class="noinput" name="lastname" type="text" placeholder="Nachname" readonly value="<?php echo get_database_entry_result(prepared_statement_result("SELECT last_name FROM users WHERE id = ?", $con, true, "s", $uid), "last_name")?>">
                </div>
            </div>
        </div>

        <div class="input-group">
            <div class="input-group-item" style="width: 100%;">
                <div class="label">
                    <label for="bio">Bio/Info</label>   
                </div>
                <div class="input-container" style="height: 50px">
                    <img src="/images/edit.svg" class="icon" alt="O">
                    <textarea id="bio-update-input" class="noinput" name="bio" placeholder="Ein kleines Intro, wer du bist" autofocus maxlength="256" wrap=""><?php echo get_database_entry_result(prepared_statement_result("SELECT bio FROM users WHERE id = ?", $con, true, "s", $uid), "bio")?></textarea>
                </div>
            </div>
        </div>
        <div class="buttons" style="display: flex; align-items: center; padding-right: 12px">
            <a href="/hub" class="link">Zurück</a>
            <div class="flex-fill"></div>
            <button class="submit-button" style="width: 7rem; margin-top: 5px">Speichern</button>
        </div>
    </form>
</div>