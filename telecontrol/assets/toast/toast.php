<?php

    if (isset($_SESSION['toast'])) {
        // Exibe o toast
        echo '<div class="toast toast-' . $_SESSION['toast']['type'] . '">
                <h2>' . $_SESSION['toast']['msg'] . '</h2>
                <button onclick="closeToast()">×</button>
            </div>';
        // Remove o toast da sessão
        unset($_SESSION['toast']);

    }
?>
<script>
    function closeToast() {
        var toast = document.querySelector('.toast');
        toast.style.display = 'none';
    }
</script>