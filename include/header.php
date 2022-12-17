<script>
    $(document).ready(function() {
        $("#logout").click(function() {
            $.get("/ajax/account/logout.php", {},
                function(data, status, jqXHR) {
                    if(!toast_json_answer(jqXHR))
                        window.location.href = "/login";
                }
            )
        })
    })
</script>

<link rel="stylesheet" href="/styles/header.css">
<div class="header">
    <div class="logo">
        <a href="/hub"><img src="/images/bjs-custom.svg" alt="Logo" width="50px"></a>
    </div>
    <div class="notice">
        Made by <a href="https://linktr.ee/brentspine" target="_blank" class="nolink pointer">Brentspine</a>
    </div>
    <div class="fill">
        
    </div>
    <div class="logout" id="logout">
        Logout
    </div>
</div>