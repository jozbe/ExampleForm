<?php
/** This view renders the registration form. Variables:
 * @var RegistrationForm $FORM
 */

// There is also a helper function for printing the errors:
/**
 * @param string|null $err the error string
 */
function is_invalid($err)
{
    if (!$err == null)
        echo ' is-invalid';
}

?>
<form method="POST">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Név<sup>*</sup></label>
        <div class="col-sm-6">
            <input type="text" class="form-control <?php is_invalid($FORM->getNameError()); ?> " id="name" name="name"
                   value="<?php echo $FORM->getNameValue(); ?>">
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getNameError(); ?>
            </small>
        </div>
    </div>
    <div class="form-group row">
        <label for="mail" class="col-sm-2 col-form-label">Email<sup>*</sup></label>
        <div class="col-sm-6">
            <input type="email" class="form-control <?php is_invalid($FORM->getMailError()); ?>" id="mail" name="mail"
                   value="<?php echo $FORM->getMailValue(); ?>">
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getMailError(); ?>
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="mail" class="col-sm-2 col-form-label">Jelszó<sup>*</sup></label>
        <div class="col-sm-6">
            <input type="password" class="form-control <?php is_invalid($FORM->getPasswordError()); ?>" id="password"
                   name="password" value="">
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getPasswordError(); ?>
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="mail" class="col-sm-2 col-form-label">Jelszó újra<sup>*</sup></label>
        <div class="col-sm-6">
            <input type="password" class="form-control <?php is_invalid($FORM->getPasswordAgainError()); ?>"
                   id="password_again" name="password_again" value="">
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getPasswordAgainError(); ?>
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="account_type" class="col-sm-2 col-form-label">Fiók típusa<sup>*</sup></label>
        <div class="col-sm-6">
            <input type="radio" id="business" name="account_type"
                   value="business" <?php echo $FORM->getAccountTypeValue() == 'business' ? 'checked' : ''; ?>>
            <label for="male">Üzleti</label><br>
            <input type="radio" id="private" name="account_type"
                   value="private" <?php echo $FORM->getAccountTypeValue() == 'private' ? 'checked' : ''; ?>>
            <label for="female">Személyes</label><br>

        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getAccountTypeError(); ?>
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="ad" class="col-sm-2 col-form-label">Hol hallott rólunk?<sup>*</sup></label>
        <div class="col-sm-6">

            <select name="ad[]" class="custom-select <?php is_invalid($FORM->getAdError()); ?>" multiple>
                <option value="tv" <?php echo $FORM->getAdValue('tv'); ?>>televízióban</option>
                <option value="piac"<?php echo $FORM->getAdValue('piac'); ?>>piacon</option>
                <option value="meccs"<?php echo $FORM->getAdValue('meccs'); ?>>meccsen</option>
                <option value="egyeb"<?php echo $FORM->getAdValue('egyeb'); ?>>egyéb</option>
            </select>

        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getAdError(); ?>
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="ad" class="col-sm-2 col-form-label">Születési dátum<sup>*</sup></label>
        <div class="col-sm-6">
            <input name="birth_date" class="datepicker form-control  <?php is_invalid($FORM->getBirthDateError()); ?>"
                   type="text" value="<?php echo $FORM->getBirthDateValue(); ?>"/>
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getBirthDateError(); ?>
            </small>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-sm-6 offset-sm-2">
            <div class="form-check">
                <input class="form-check-input <?php is_invalid($FORM->getTermsError()); ?>" type="checkbox" id="terms"
                       name="terms" value="yes"<?php echo $FORM->getTermsValue(); ?>>
                <label class="form-check-label" for="terms">
                    A Jogi szabályzatot elolvastam és elfogadom.<sup>*</sup>
                </label>
            </div>
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getTermsError(); ?>
            </small>
        </div>
    </div>

    <div class="form-group row">
        <label for="friend_mail" class="col-sm-2 col-form-label">Barát meghívása</label>
        <div class="col-sm-6">
            <input type="email" class="form-control <?php is_invalid($FORM->getFriendMailError()); ?>" id="friend_mail"
                   name="friend_mail" value="<?php echo $FORM->getFriendMailValue(); ?>">
        </div>
        <div class="col-sm-4">
            <small class="text-danger">
                <?php echo $FORM->getFriendMailError(); ?>
            </small>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-sm-6 offset-sm-2">
            <button type="submit" name="submit" class="btn btn-success">KÜLDÉS</button>
        </div>
    </div>
</form>


<script type="text/javascript">
    $('.datepicker').datepicker({
        weekStart: 1,
        color: 'red'
    });
</script>


