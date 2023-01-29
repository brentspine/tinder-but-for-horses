<div class="poll">
    <h1>Hansenberg Tinder</h1>
    <p>Willkommen zum Hansenberg Tinder, gebe an wen du unbedingt schon einmal SMASHEN wolltest YEAH</p>
    <div class="input-group" style="width: unset!important;">
        <div class="input-container">
            <img src="/images/search.svg" class="icon" alt="">
            <input class="noinput" id="search-user-input" type="text" placeholder="Schüler suchen">
        </div>
        <div class="user-search-suggestions" id="user-search-suggestions">
            Enter something
        </div>
    </div>
    <div class="selected-users">
        <?php
            $sql = "SELECT users.first_name, users.last_name, users.id FROM smash LEFT JOIN users ON users.id & smash.target WHERE users.id = target AND smash.uid = ?";
            $result = prepared_statement_result($sql, $con, true, "s", $uid);
            foreach(get_multiple_database_entries_result($result, ["first_name", "last_name", "id"]) as $c) {
                echo "<div data-id='".htmlspecialchars($c[2])."'><span>".htmlspecialchars($c[0])." ".htmlspecialchars($c[1])."</span>" . "<div class='flex-fill'></div>" . "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_smash(\"".htmlspecialchars($c[2])."\")'></div>";
            }
        ?>
    </div>
</div>