<div class="row">
    <h5><?php $oTrad->trad("home", "3"); ?></h5>
    <form action="traitment.php" method="POST" class="form">
        <?php
            echo '<input type="hidden" name="code_customer" value="' . $oCustomer->intCode_customer . '">';
            echo '<input type="hidden" name="lang" value="' . LANG . '">';

            
            
            echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_sms == 1){
                echo '<input type="checkbox" name="sms" id="sms" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="sms" id="sms" class="form-check-input checkboxes">';
            }
            echo '<label for="sms" class="form-check-label rouge">' . $oTrad->trad("home", "4") . '</label>';
            echo '</div>';
            

            echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_email == 1){
                echo '<input type="checkbox" name="email" id="email" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="email" id="email" class="form-check-input checkboxes">';
                }
                echo '<label for="email" class="form-check-label rouge">' . $oTrad->trad("home", "5") . '</label>';
            echo '</div>';
                
                
            echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_mail == 1){
                echo '<input type="checkbox" name="mail" id="mail" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="mail" id="mail" class="form-check-input checkboxes">';
            }
                echo '<label for="mail" class="form-check-label rouge">' . $oTrad->trad("home", "6") . '</label>';
            echo '</div>';
            
            /* echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_phone == 1){
                echo '<input type="checkbox" name="phone" id="phone" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="phone" id="phone" class="form-check-input checkboxes" >';
            }
                echo '<label for="phone" class="form-check-label rouge">Par téléphone</label>';
            echo '</div>'; */

            echo '<div class="form-checkbox pb-2">';
            if (/* $oCustomer->isOptIn_phone == 0 || */ $oCustomer->isOptIn_phone == null && $oCustomer->isOptIn_email == 0 || $oCustomer->isOptIn_email == null && $oCustomer->isOptIn_mail == 0 || $oCustomer->isOptIn_mail == null && $oCustomer->isOptIn_sms == 0 || $oCustomer->isOptIn_sms == null){
                echo '<input type="checkbox" name="opt_in_none" id="opt_in_none" class="form-check-input rose" checked>';
            } else {
                echo '<input type="checkbox" name="opt_in_none" id="opt_in_none" class="form-check-input" >';
            }
                echo '<label for="opt_in_none" class="form-check-label rouge">' . $oTrad->trad("home", "7") . '</label>';
            echo '</div>';
            echo '<div class="msgError"></div>';
        echo '</br>';
        echo '<input type="submit" class="btn btn-primary rose-btn shadow-sm inputValided" value="' . $oTrad->trad("home", "8") . '">';
    echo '</form>';
echo '</div>';
echo '<div class="row">'
?>

