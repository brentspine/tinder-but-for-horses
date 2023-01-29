<div class="results">
    <h1>Hansenberg Tinder</h1>
    <p>Es ist soweit! Die Ergebnisse sind da! Es haben <?php echo prepared_statement_result("SELECT * FROM users", $con, false, "") -> num_rows ?> Schüler insgesamt <?php echo prepared_statement_result("SELECT * FROM smash", $con, false, "") -> num_rows ?> Leute als SMASH markiert. Daraus ergaben sich <?php echo prepared_statement_result("SELECT T1.uid, T1.target FROM smash T1, smash T2 WHERE T1.uid = T2.target AND T2.uid = T1.target", $con, false, "") -> num_rows / 2 ?> Matches</p>
    <div class="matches">
        <h3>Du hast <?php echo prepared_statement_result("SELECT T1.uid, T1.target FROM smash T1, smash T2 WHERE T1.uid = T2.target AND T2.uid = T1.target AND T1.uid = ?", $con, true, "s", $uid) -> num_rows ?> Match(es):</h3>
        <ul>
            <?php 
                $matches = get_multiple_database_entries_result(prepared_statement_result("SELECT T1.uid, T1.target, T3.first_name, T3.last_name FROM smash T1, smash T2, users T3 WHERE T1.uid = T2.target AND T2.uid = T1.target AND T3.id = T1.target AND T1.uid = ?", $con, true, "s", $uid), ["target", "first_name", "last_name"]);
                foreach($matches as $c) {
                    echo "<li>".htmlspecialchars($c[1])." ".htmlspecialchars($c[2])."</li>";
                }
            ?>
        </ul>
    </div>
</div>