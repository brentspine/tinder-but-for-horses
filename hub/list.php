<style>
    .your-list {
        display: flex;
    }
    .your-list div {
        display: flex;
        justify-content: center;
    }
    .your-list .title {
        font-weight: bold;
        font-size: 1.2rem;
        text-align: center;
    }

    .your-list .your-list-item {
        display: flex;
        flex-direction: column;
        width: 100%;
        /*max-width: 300px;*/
        padding-top: 5px;
    }
    .your-list .your-list-item div {
        margin: 0 20px;
        display: flex;
        align-items: center;
        padding: 3px 0;
    }
    .your-list .your-list-item div img {
        padding-left: 5px;
    }

    .passes {
        margin-top: 25px;
    }

    p {
        color: var(--color-standard-grey);
        text-align: center;
    }
</style>

<script>
    function remove_smash(id) {
        $.post("/ajax/smash/remove_smash.php", {user: id},
            function (data, textStatus, jqXHR) {
                toast_json_answer(data);
                $(".your-list .smashes div[data-id='"+id+"']").remove();
                check_empty_list()
            }
        );
    }

    function remove_pass(id) {
        $.post("/ajax/smash/remove_pass.php", {user: id},
            function (data, textStatus, jqXHR) {
                toast_json_answer(data);
                $(".your-list .passes div[data-id='"+id+"']").remove();
                check_empty_list()
            }
        );
    }

    $(document).ready(function () {
        check_empty_list()
    });
    function check_empty_list() {
        if($(".your-list .smashes div").length <= 0 && $(".your-list .smashes p").length <= 0)
            $(".your-list .smashes").append("<p>Noch keine Einträge</p>");
        if($(".your-list .passes div").length <= 0 && $(".your-list .passes p").length <= 0)
            $(".your-list .passes").append("<p>Noch keine Einträge</p>");
    }

</script>

<div class="your-list">
    <a href="/hub" style="margin-bottom: 1rem;">Zurück</a>
    <div class="your-list-item smashes">
        <span class="title">Smash</span>
        <?php
            $sql = "SELECT users.first_name, users.last_name, users.id FROM smash LEFT JOIN users ON users.id & smash.target WHERE users.id = target AND smash.uid = ?";
            $result = prepared_statement_result($sql, $con, true, "s", $uid);
            foreach(get_multiple_database_entries_result($result, ["first_name", "last_name", "id"]) as $c) {
                echo "<div data-id='".$c[2]."'><span>".$c[0]." ".$c[1]."</span>" . "<div class='flex-fill'></div>" . "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_smash(\"".$c[2]."\")'></div>";
            }
        ?>
    </div>
    <div class="your-list-item passes">
        <span class="title">Pass</span>
        <?php
            $sql = "SELECT users.first_name, users.last_name, users.id FROM pass LEFT JOIN users ON users.id & pass.target WHERE users.id = target AND pass.uid = ?";
            $result = prepared_statement_result($sql, $con, true, "s", $uid);
            foreach(get_multiple_database_entries_result($result, ["first_name", "last_name", "id"]) as $c) {
                echo "<div data-id='".$c[2]."'><span>".$c[0]." ".$c[1]."</span>" . "<div class='flex-fill'></div>" . "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_pass(\"".$c[2]."\")'></div>";
            }
        ?>
    </div>
</div>