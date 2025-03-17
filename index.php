<?php
include 'db_connect.php';

// Fetch data from tables
$utenti = $conn->query("SELECT * FROM utenti")->fetch_all(MYSQLI_ASSOC);
$macchinari = $conn->query("SELECT * FROM macchinari")->fetch_all(MYSQLI_ASSOC);
$causali = $conn->query("SELECT * FROM causali")->fetch_all(MYSQLI_ASSOC);

// Initialize selected values
$selected_user = isset($_POST['id_utente']) ? $_POST['id_utente'] : null;
$selected_machine = isset($_POST['id_macchinario']) ? $_POST['id_macchinario'] : null;
$selected_causale = isset($_POST['id_causale']) ? $_POST['id_causale'] : null;
$show_causale = false; // Initialize flag

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['start'])) {
        $id_utente = $_POST['id_utente'];
        $id_macchinario = $_POST['id_macchinario'];
        $stmt = $conn->prepare("INSERT INTO eventi (id_utente, id_macchinario, data_ora, evento) VALUES (?, ?, NOW(), 1)");
        $stmt->bind_param("ii", $id_utente, $id_macchinario);
        if ($stmt->execute()) {
            // Success (you can add a message here)
        } else {
            // Error handling (you can add error logging here)
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['stop_request'])) {
        $show_causale = true;
    } elseif (isset($_POST['confirm_stop'])) {
        $id_causale = $_POST['id_causale'];
        $id_utente = $_POST['id_utente'];
        $id_macchinario = $_POST['id_macchinario'];
        $stmt = $conn->prepare("INSERT INTO eventi (id_utente, id_macchinario, data_ora, id_causale, evento) VALUES (?, ?, NOW(), ?, 2)");
        $stmt->bind_param("iii", $id_utente, $id_macchinario, $id_causale);
        if ($stmt->execute()) {
            // Success (you can add a message here)
        } else {
            // Error handling (you can add error logging here)
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $show_causale = false;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="simple.css">
    <title>Causali Macchinari</title>
    <script>
        function updateClock() {
            var now = new Date();
            var time = now.toLocaleTimeString();
            document.getElementById('clock').textContent = time;
            setTimeout(updateClock, 1000);
        }
    </script>
</head>
<body onload="updateClock()">
    <div id="clock" style="text-align: left; font-size: 24px; margin-bottom: 20px;"></div>
    <form method="post">
        <label for="id_utente">Utente:</label>
        <select name="id_utente">
            <?php foreach ($utenti as $utente): ?>
                <option value="<?php echo $utente['id']; ?>" <?php if ($selected_user == $utente['id']) echo 'selected'; ?>>
                    <?php echo $utente['utente']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="id_macchinario">Macchinario:</label>
        <select name="id_macchinario">
            <?php foreach ($macchinari as $macchinario): ?>
                <option value="<?php echo $macchinario['id']; ?>" <?php if ($selected_machine == $macchinario['id']) echo 'selected'; ?>>
                    <?php echo $macchinario['macchinario']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>

        <button type="submit" name="start">Start</button>
        <button type="submit" name="stop_request">Stop</button>

        <?php if ($show_causale): ?>
            <label for="id_causale">Causale:</label>
            <select name="id_causale">
                <?php foreach ($causali as $causale): ?>
                    <option value="<?php echo $causale['id']; ?>" <?php if ($selected_causale == $causale['id']) echo 'selected'; ?>>
                        <?php echo $causale['causale']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="confirm_stop">Confirm Stop</button>
        <?php endif; ?>
    </form>
</body>
</html>