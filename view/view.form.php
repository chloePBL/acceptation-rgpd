<div class="row">
    <form action="traitment.php" method="POST">
        <?php
            echo '<input type="hidden" name="code_customer" value="' . $oCustomer->intCode_customer . '">';

            echo '<div class="form-checkbox pb-2">';
                if ($oCustomer->isOptIn_phone == 1){
                    echo '<input type="checkbox" name="phone" id="phone" class="form-check-input rose" checked>';
                } else {
                    echo '<input type="checkbox" name="phone" id="phone" class="form-check-input" >';
                }
                echo '<label for="phone" class="form-check-label rouge">Je souhaite recevoir les offres exclusives Bleu Libellule et les dernières tendances par téléphone</label>';
            echo '</div>';

            
            echo '<div class="form-checkbox pb-2">';
                if ($oCustomer->isOptIn_sms == 1){
                    echo '<input type="checkbox" name="sms" id="sms" class="form-check-input rose" checked>';
                } else {
                    echo '<input type="checkbox" name="sms" id="sms" class="form-check-input">';
                }
                echo '<label for="sms" class="form-check-label rouge">Je souhaite recevoir les offres et communications Bleu Libellule par SMS</label>';
            echo '</div>';


            echo '<div class="form-checkbox pb-2">';
                if ($oCustomer->isOptIn_email == 1){
                    echo '<input type="checkbox" name="email" id="email" class="form-check-input rose" checked>';
                } else {
                    echo '<input type="checkbox" name="email" id="email" class="form-check-input">';
                }
                echo '<label for="email" class="form-check-label rouge">Je souhaite recevoir les offres exclusives Bleu Libellule et les dernières tendances par mail</label>';
            echo '</div>';


            echo '<div class="form-checkbox pb-2">';
                if ($oCustomer->isOptIn_mail == 1){
                    echo '<input type="checkbox" name="mail" id="mail" class="form-check-input rose" checked>';
                } else {
                    echo '<input type="checkbox" name="mail" id="mail" class="form-check-input">';
                }
                echo '<label for="mail" class="form-check-label rouge">Je souhaite recevoir les offres exclusives Bleu Libellule et les dernières tendances par courrier</label>';
        ?>
            </div>
        </br>
        <input type="submit" class="btn btn-primary rose-btn shadow-sm" value="Valider">
    </form>
</div>
<div class="row">

