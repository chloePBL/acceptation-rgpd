<div class="row">
    <h5>Validez ou modifiez vos préférences de communications communiqués à nos équipes. <br>Vous souhaitez recevoir ces communications :</h5>
    <form action="traitment.php" method="POST" class="form">
        <?php
            echo '<input type="hidden" name="code_customer" value="' . $oCustomer->intCode_customer . '">';

            
            
            echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_sms == 1){
                echo '<input type="checkbox" name="sms" id="sms" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="sms" id="sms" class="form-check-input checkboxes">';
            }
            echo '<label for="sms" class="form-check-label rouge">Par sms</label>';
            echo '</div>';
            

            echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_email == 1){
                echo '<input type="checkbox" name="email" id="email" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="email" id="email" class="form-check-input checkboxes">';
                }
                echo '<label for="email" class="form-check-label rouge">Par email</label>';
            echo '</div>';
                
                
            echo '<div class="form-checkbox pb-2">';
            if ($oCustomer->isOptIn_mail == 1){
                echo '<input type="checkbox" name="mail" id="mail" class="form-check-input checkboxes rose" checked>';
            } else {
                echo '<input type="checkbox" name="mail" id="mail" class="form-check-input checkboxes">';
            }
                echo '<label for="mail" class="form-check-label rouge">Par courrier postal</label>';
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
            if ($oCustomer->isOptIn_phone == 0 || $oCustomer->isOptIn_phone == null && $oCustomer->isOptIn_email == 0 || $oCustomer->isOptIn_email == null && $oCustomer->isOptIn_mail == 0 || $oCustomer->isOptIn_mail == null && $oCustomer->isOptIn_sms == 0 || $oCustomer->isOptIn_sms == null){
                echo '<input type="checkbox" name="opt_in_none" id="opt_in_none" class="form-check-input rose" checked>';
            } else {
                echo '<input type="checkbox" name="opt_in_none" id="opt_in_none" class="form-check-input" >';
            }
                echo '<label for="opt_in_none" class="form-check-label rouge">Je ne souhaite pas recevoir de communications Bleu Libellule</label>';
                ?>
            </div>
            <div class="msgError"></div>
        </br>
        <input type="submit" class="btn btn-primary rose-btn shadow-sm inputValided" value="VALIDER MES PRÉFÉRENCES">
    </form>
</div>
<div class="row">

