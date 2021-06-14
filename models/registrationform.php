<?php

require_once '../autoloader.php';

class RegistrationForm
{
    /** @var string */
    protected $field_name;
    /** @var string */
    protected $field_mail;
    /** @var string */
    protected $field_password;
    /** @var string */
    protected $field_password_again;
    /** @var string */
    protected $field_account_type;
    /** @var string */
    protected $field_ad;
    /** @var string */
    protected $field_birth_date;
    /** @var string */
    protected $field_terms;
    protected $field_friend_mail;
    /** @var string */


    /** @var array */
    protected $select_ad = ['tv', 'piac', 'meccs', 'egyeb'];

    /** @var string|null */
    protected $error_name = null;
    /** @var string|null */
    protected $error_mail = null;
    /** @var string|null */
    protected $error_password = null;
    /** @var string|null */
    protected $error_password_again = null;
    /** @var string|null */
    protected $error_account_type = null;
    /** @var string|null */
    protected $error_ad = null;
    /** @var string|null */
    protected $error_birth_date = null;
    /** @var string|null */
    protected $error_terms = null;
    /** @var string|null */
    protected $error_friend_mail = null;

    /** @var bool */
    private $is_submitted = false;
    /** @var bool */
    private $is_valid = false;
    /** @var string */
    protected $token;


    public function getToken()
    {
        return $this->token;
    }

    private $conn;

    public function __construct($POST_DATA = null)
    {
        // Initialize DB connection
        $db = DB::getInstance();
        $this->conn = $db->getConnection();

        if (!is_null($POST_DATA)) {
            $this->field_name = $POST_DATA['name'] ?? "";
            $this->field_mail = $POST_DATA['mail'] ?? "";
            $this->field_password = $POST_DATA['password'] ?? "";
            $this->field_password_again = $POST_DATA['password_again'] ?? "";
            $this->field_account_type = $POST_DATA['account_type'] ?? null;
            $this->field_ad = $POST_DATA['ad'] ?? [];
            $this->field_birth_date = $POST_DATA['birth_date'] ?? null;
            $this->field_friend_mail = $POST_DATA['friend_mail'] ?? "";
            $this->field_terms = $POST_DATA['terms'] ?? "no";
            $this->is_submitted = isset($POST_DATA['submit']);
        }
    }

    public function validate()
    {
        // Validate name
        $this->valid = true;

        $this->validateName();
        $this->validateMail();
        $this->validatePassword();
        $this->validatePasswordAgain();
        $this->validateAccountType();
        $this->validateAd();
        $this->validateBirthDate();
        $this->error_terms = $this->validateTerms() ? null : 'A Jogi szabályzat elfogadása kötelező!';
        $this->validateFriendMail();

        $this->is_valid = is_null($this->error_name) && is_null($this->error_mail) && is_null($this->error_password) && is_null($this->error_password_again) && is_null($this->error_account_type) && is_null($this->error_ad) &&
            is_null($this->error_terms) && is_null($this->error_birth_date) && is_null($this->error_friend_mail);
    }


    private function validateName()
    {
        if (strlen($this->field_name) == 0)
            $this->error_name = 'A név megadása kötelező!';
        else if (strlen($this->field_name) > 75)
            $this->error_name = 'A név túl hosszú!';
        else
            $this->error_name = null;

    }


    private function validateMail()
    {
        if (strlen($this->field_mail) == 0) {
            $this->error_mail = 'Az email cím megadása kötelező!';
        } else if (filter_var($this->field_mail, FILTER_VALIDATE_EMAIL)) {
            $this->error_mail = null;
        } else {
            $this->error_mail = "Hibás e-mail cím formátum";
        }
    }

    private function validateFriendMail()
    {
        if (strlen($this->field_friend_mail) == 0) {
            $this->error_friend_mail = null;
        } else if (filter_var($this->field_friend_mail, FILTER_VALIDATE_EMAIL)) {
            $this->error_friend_mail = null;
        } else {
            $this->error_friend_mail = "Hibás e-mail cím formátum";
        }
    }


    private function validatePassword()
    {
        if (strlen($this->field_password) == 0)
            $this->error_password = 'A jelszó megadása kötelező!';
        else if (strlen($this->field_password) > 7 && preg_match('@[A-Z]@', $this->field_password) && $specialChars = preg_match('@[^\w]@', $this->field_password)) {
            $this->error_password = null;
        } else
            $this->error_password = 'Nem elég biztonságos jelszó!';
    }

    private function validatePasswordAgain()
    {
        $this->error_password_again = $this->field_password == $this->field_password_again ? null : 'A két jelszónak egyeznie kell!';
    }

    private function validateAccountType()
    {
        if ($this->field_account_type == 'business' or $this->field_account_type == 'private') {
            $this->error_account_type = null;
        } else {
            $this->error_account_type = 'A fiók típus választása kötelező!';
        }
    }

    private function validateAd()
    {
        $this->error_ad = null;
        if(sizeof($this->field_ad)==0){
            $this->error_ad = 'Legalább egy elem választása kötelező!';
        }
        foreach ($this->field_ad as $item) {
            if (!in_array($item, $this->select_ad)) {
                $this->error_ad = 'Csak a listában szereplő elemek közül lehet választani!';
            }
        }
    }

    private function validateBirthDate()
    {
        $this->error_birth_date = null;
        $date = null;
        if (strlen($this->field_birth_date) == 0) {
            $this->error_birth_date = 'A születési dátum megadása kötelező!';
        } else {
            try {
                $date = new DateTime($this->field_birth_date);
                if (time() < strtotime('+18 years', strtotime($this->field_birth_date))) {
                    $this->error_birth_date = 'A regisztráció csak 18 éven felüliek számára engedélyezett!';
                }
            } catch (Exception $e) {
                $this->error_birth_date = 'Hibás dátum! A megfelelő formátum a következő: mm/dd/yyyy.';
                $date = null;
            }
        }

    }

    private function validateTerms()
    {
        return $this->field_terms == 'yes';
    }


    public function save()
    {
        $this->validate();
        if (!$this->is_valid) {
            return false;
        } else {
            try {
                $statement = $this->conn->prepare('INSERT INTO users (name, email, password, account,ad,birthdate,friend) VALUES (:name, :email, :pass, :account, :ad, :birthdate,:friend)');
                $statement->bindParam(':name', $this->field_name);
                $statement->bindParam(':email', $this->field_mail);
                $hash = password_hash($this->field_password, PASSWORD_BCRYPT, ['cost' => 12]);
                $statement->bindParam(':pass', $hash);
                $statement->bindParam(':account', $this->field_account_type);
                $implode = implode("|", $this->field_ad);
                $statement->bindParam(':ad', $implode);
                $statement->bindParam(':birthdate', $this->field_birth_date);
                $statement->bindParam(':friend', $this->field_friend_mail);
                $statement->execute();

            } catch (PDOException $exception) {
                echo $exception->getMessage();
                return false;
            }
            return true;

        }
    }

    public function mailToDB()
    {
        $this->validate();
        if (!$this->is_valid) {
            return false;
        } else {
            try {
                $statement = $this->conn->prepare('INSERT INTO invitations (mail_from, mail_to, status) VALUES (:mail_from, :mail_to, "sent")');
                $statement->bindParam(':mail_from', $this->field_mail);
                $statement->bindParam(':mail_to', $this->field_friend_mail);
                $statement->execute();

            } catch (PDOException $exception) {
                echo $exception->getMessage();
                return false;
            }
            return true;
        }
    }

    /**
     * GETTERS
     */

    public function isSubmitted()
    {
        return $this->is_submitted;
    }

    public function isValid()
    {
        return $this->is_valid;
    }

    public function getNameValue()
    {
        return $this->field_name;
    }

    public function getNameError()
    {
        return $this->error_name;
    }

    public function getPasswordError()
    {
        return $this->error_password;
    }

    public function getPasswordAgainError()
    {
        return $this->error_password_again;
    }

    public function getMailValue()
    {
        return $this->field_mail;
    }

    public function getMailError()
    {
        return $this->error_mail;
    }

    public function getFriendMailValue()
    {
        return $this->field_friend_mail;
    }

    public function getFriendMailError()
    {
        return $this->error_friend_mail;
    }

    public function getAccountTypeValue()
    {
        if ($this->field_account_type == 'business') {
            return 'business';
        } else if ($this->field_account_type == 'private') {
            return 'private';
        } else
            return '';
    }

    public function getAccountTypeError()
    {
        return $this->error_account_type;
    }

    public function getTermsValue()
    {
        return $this->field_terms == 'yes' ? 'checked' : '';
    }

    public function getAdValue($field)
    {
        return in_array($field, $this->field_ad) ? 'selected' : '';
    }

    public function getBirthDateValue()
    {
        return $this->field_birth_date;
    }

    public function getAdError()
    {
        return $this->error_ad;
    }

    public function getBirthDateError()
    {
        return $this->error_birth_date;
    }

    public function getTermsError()
    {
        return $this->error_terms;
    }
}