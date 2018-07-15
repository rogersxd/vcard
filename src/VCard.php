<?php 

namespace Rogersxd\VCard;

/**
*  VCard Class
*
*  @author Rogers Corrêa
*/

class VCard{

    /**
    * existsElements
    *
    * @var array
    */
    private $existsElements;

    /**
    * charset
    *
    * @var string
    */
    private $charset = 'UTF-8';

    /**
    * filename
    *
    * @var string
    */
    private $filename;

    /**
    * properties
    *
    * @var array
    */
    private $properties;

    /**
     * Save Path
     *
     * @var string
     */
    private $savePath = null;

    /**
    * multipleAllowed
    *
    * @var array
    */

    private $multipleAllowed;

    /**
    * Construct method 
    *
    * Set filename on init and difine the multiple properties allowed
    *
    * @return string
    */
    
    public function __construct()
    {
        $this->setFilename(uniqid());

        $this->multipleAllowed = [
            'email',
            'address',
            'phone',
            'url',
            'label',
            'custom',
            'social'
        ];
    }

    /**
    * Add names method
    *
    * @param  string [optional] $lastName
    * @param  string [optional] $firstName
    * @param  string [optional] $additional
    * @param  string [optional] $prefix
    * @param  string [optional] $suffix
    * @return $this
    */

    public function addNames(
        $lastName = '',
        $firstName = '',
        $additional = '',
        $prefix = '',
        $suffix = ''
    ){
        // set property
        $property = $lastName . ';' . $firstName . ';' . $additional . ';' . $prefix . ';' . $suffix;
        $this->setProperty(
            'name',
            'N' . $this->getCharsetInVCard(),
            $property
        );

        return $this;
    }

    /**
    * Add phone number
    *
    * @param  string $number
    * @param  string [optional] $type
    * TYPES = PREF | WORK | HOME | VOICE | FAX | MSG |
    * CELL | PAGER | BBS | CAR | MODEM | ISDN | VIDEO
    * @return $this
    */
    public function addPhone($number, $type = '')
    {
        $this->setProperty(
            'phone',
            'TEL' . (($type != '') ? ';' . $type : ''),
            $number
        );

        return $this;
    }

    /**
    * Add role
    *
    * @param  string $role.
    * @return $this
    */
    public function addRole($role)
    {
        $this->setProperty(
            'role',
            'ROLE' . $this->getCharsetInVCard(),
            $role
        );

        return $this;
    }

    /**
     * Add email
     *
     * @param  string $email E-mail address
     * @param  string [optional] $type
     * TYPES = PREF | WORK | HOME;
     * @return $this
     */
    public function addEmail($email, $type = '')
    {
        $this->setProperty(
            'email',
            'EMAIL;INTERNET' . (($type != '') ? ';' . $type : ''),
            $email
        );

        return $this;
    }

    /**
    * Add company
    *
    * @param string $company
    * @param string $department
    * @return $this
    */
    public function addCompany($company, $department = '')
    {
        $this->setProperty(
            'company',
            'ORG' . $this->getCharsetInVCard(),
            $company
            . ($department != '' ? ';' . $department : '')
        );

        return $this;
    }

    /**
    * Add note
    *
    * @param  string $note
    * @return $this
    */
    public function addNote($note)
    {
        $this->setProperty(
            'note',
            'NOTE' . $this->getCharsetInVCard(),
            $note
        );

        return $this;
    }

    /**
    * Add Photo
    *
    * @param  string $path image url or path
    * @return $this
    */
    public function addPhoto($path)
    {
        $mimeType = null;

        if (filter_var($path, FILTER_VALIDATE_URL) !== false) {

            $headers = get_headers($path, 1);

            if (array_key_exists('Content-Type', $headers)) {
                $mimeType = $headers['Content-Type'];
                if (is_array($mimeType)) {
                    $mimeType = end($mimeType);
                }
            }
        } else {
            $mimeType = mime_content_type($path);
        }

        if (strpos($mimeType, ';') !== false) {
            $mimeType = strstr($mimeType, ';', true);
        }
        if (!is_string($mimeType) || substr($mimeType, 0, 6) !== 'image/') {
            throw VCardException::invalidImage();
        }
        $fileType = strtoupper(substr($mimeType, 6));

        if ((bool) ini_get('allow_url_fopen') === true) {
            $value = file_get_contents($path);
        } else {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $path);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $value = curl_exec($curl);
            curl_close($curl);
        }

        if (!$value) {
            throw VCardException::emptyURL();
        }

        $value = base64_encode($value);

        $property = "PHOTO;ENCODING=BASE64;TYPE=" . $fileType;

        $this->setProperty(
            'photo',
            $property,
            $value
        );

        return $this;
    }

    /**
    * Add URL
    *
    * @param  string $url
    * @param  string [optional] $type Type may be WORK | HOME
    * @return $this
    */
    public function addURL($url, $type = '')
    {
        $this->setProperty(
            'url',
            'URL' . (($type != '') ? ';' . $type : ''),
            $url
        );

        return $this;
    }

    /**
    * Add address
    *
    * @param  string [optional] $socialProfile
    * @param  string [optional] $type
    * TYPES = facebook | twitter | instagram | linkedin
    * @return $this
    */
    public function addSocialProfile($socialProfile, $type)
    {
        $this->setProperty(
            'social',
            'X-SOCIALPROFILE;type='. $type,
            $socialProfile
        );

        return $this;
    }

    /**
    * Add address
    *
    * @param  string [optional] $name
    * @param  string [optional] $extended
    * @param  string [optional] $street
    * @param  string [optional] $city
    * @param  string [optional] $region
    * @param  string [optional] $zip
    * @param  string [optional] $country
    * @param  string [optional] $type
    * TYPES = DOM | INTL | POSTAL | PARCEL | HOME | WORK
    * @return $this
    */
    public function addAddress(
        $name = '',
        $extended = '',
        $street = '',
        $city = '',
        $region = '',
        $zip = '',
        $country = '',
        $type = 'WORK;POSTAL'
    ) {

        $value = $name . ';' . $extended . ';' . $street . ';' . $city . ';' . $region . ';' . $zip . ';' . $country;

        $this->setProperty(
            'address',
            'ADR' . (($type != '') ? ';' . $type : '') . $this->getCharsetInVCard(),
            $value
        );

        return $this;
    }

    /**
    * Add custom
    *
    * @param  string [optional] $custom
    * @return $this
    */
    public function addCustom($custom)
    {
        $this->setProperty(
            'custom',
            '',
            $custom
        );

        return $this;
    }
    /**
    * Set charset string
    */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
    * Get charset in vCard
    *
    * @return string
    */
    public function getCharsetInVCard()
    {
        return ';CHARSET=' . $this->charset;
    }

    /**
    * Get charset string
    *
    * @return string
    */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
    * Set property
    *
    * @param  string $element
    * @param  string $key
    * @param  string $value
    * @throws VCardException
    */
    public function setFilename($value, $overwrite = true)
    {
        $value = trim($value);

        $value = preg_replace('/\s+/', ' ', $value);

        if (empty($value)) {
            return;
        }

        $value = strtolower($value);

        $this->filename = ($overwrite) ?
        $value : $this->filename . $value;
    }

    /**
    * Get filename
    *
    * @return string
    */
    public function getFilename()
    {
        if (!$this->filename) {
            return 'unknown';
        }

        return $this->filename;
    }

    /**
    * Set property
    *
    * @param  string $element
    * @param  string $key
    * @param  string $value
    * @throws VCardException
    */

    private function setProperty($element, $key, $value)
    {
        if (!in_array($element, $this->multipleAllowed)
            && isset($this->existsElements[$element])
        ) {
            throw VCardException::elementExists($element);
        }

            // we define that we set this element
        $this->existsElements[$element] = true;

            // adding property
        $this->properties[] = [
            'key' => $key,
            'value' => $value
        ];
    }

    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Build VCard (.vcf)
     *
     * @return string
     */
    public function genVCard()
    {
        // init string
        $string = "BEGIN:VCARD\r\n";
        $string .= "VERSION:3.0\r\n";
        $string .= "REV:" . date("Y-m-d") . "T" . date("H:i:s") . "Z\r\n";

        // loop all properties
        $properties = $this->getProperties();
        foreach ($properties as $property) {
            // add to string
            $string .= $this->fold($property['key'] . ':' . $this->escape($property['value']) . "\r\n");
        }

        // add to string
        $string .= "END:VCARD\r\n";

        // return
        return $string;
    }

    /**
    * Set the save path directory
    *
    * @param  string $savePath Save Path
    * @throws VCardException
    */
    public function setSavePath($savePath)
    {
        if (!is_dir($savePath)) {
            throw VCardException::outputDirectoryNotExists();
        }

        // Add trailing directory separator the save path
        if (substr($savePath, -1) != DIRECTORY_SEPARATOR) {
            $savePath .= DIRECTORY_SEPARATOR;
        }

        $this->savePath = $savePath;
    }


    /**
     * Save to a file
     *
     * @return void
     */
    public function save()
    {
        $file = $this->getFilename() . '.vcf';

        // Add save path if given
        if (null !== $this->savePath) {
            $file = $this->savePath . $file;
        }

        file_put_contents(
            $file,
            $this->genVCard()
        );
    }


    /**
    * Fold a line according to RFC2425 section 5.8.1.
    *
    * @link http://tools.ietf.org/html/rfc2425#section-5.8.1
    * @param  string $text
    * @return mixed
    */
    protected function fold($text)
    {
        if (strlen($text) <= 75) {
            return $text;
        }

        // split, wrap and trim trailing separator
        return substr($this->chunk_split_unicode($text, 75, "\r\n "), 0, -3);
    }

    /**
    * multibyte word chunk split
    * @link http://php.net/manual/en/function.chunk-split.php#107711
    * 
    * @param  string  $body     The string to be chunked.
    * @param  integer $chunklen The chunk length.
    * @param  string  $end      The line ending sequence.
    * @return string            Chunked string
    */
    protected function chunk_split_unicode($body, $chunklen = 76, $end = "\r\n")
    {
        $array = array_chunk(
            preg_split("//u", $body, -1, PREG_SPLIT_NO_EMPTY), $chunklen);
        $body = "";
        foreach ($array as $item) {
            $body .= join("", $item) . $end;
        }
        return $body;
    }

    /**
    * Escape newline characters according to RFC2425 section 5.8.4.
    *
    * @link http://tools.ietf.org/html/rfc2425#section-5.8.4
    * @param  string $text
    * @return string
    */
    protected function escape($text)
    {
        $text = str_replace("\r\n", "\\n", $text);
        $text = str_replace("\n", "\\n", $text);

        return $text;
    }
}