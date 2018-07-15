<?php 

use Rogersxd\VCard\VCard;

/**
*  Corresponding Class to test VCard class
*
*  @author Rogers Corrêa
*/

class VCardTest extends PHPUnit_Framework_TestCase{

    /**
    * @var VCard
    */

    protected $vcard = null;

    /**
    * Init setup informations to test VCard
    *
    */

    public function setup() {

        $this->vcard = new VCard();

    }

    public function testSetCharset(){

        $charset = 'ISO-8859-1';

        $charsetInVcard = ';CHARSET=ISO-8859-1';

        $this->vcard->setCharset($charset);

        $this->assertEquals($this->vcard->getCharset(), $charset);

        $this->assertEquals($this->vcard->getCharsetInVcard(), $charsetInVcard);
    }

    public function testAddNames()
    {
        
        $lastName = 'Corrêa';
        $firstName = 'Rogers';
        $additional = '';
        $prefix = '';
        $suffix = '';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addnames(
                $lastName, 
                $firstName, 
                $additional, 
                $prefix, 
                $suffix
            )
        );
    }

    public function testAddPhone()
    {
        $type1 = 'CELL';
        $phone1 = '+5551999999999';

        $type2 = 'WORK';
        $phone2 = '+555133333333';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addPhone(
                $phone1,
                $type1
            )
        );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addPhone(
                $phone2,
                $type2
            )
        );
    }

    public function testAddRole()
    {
        
        $role = 'Dev';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addRole(
                $role
            )
        );
    }

    public function testAddEmail()
    {
        
        $email = 'test@test.com';
        $type = 'WORK';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addEmail(
                $email,
                $type
            )
        );
    }

    public function testAddCompany()
    {
        
        $company = 'XYZ';
        $department = 'IT';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addCompany(
                $company,
                $department
            )
        );
    }

    public function testAddUrl()
    {
        
        $url1 = 'http://rogerscorrea.wordpress.com';
        $url2 = 'https://github.com/rogersxd';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addurl(
                $url1
            )
        );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addurl(
                $url2
            )
        );
    }

    public function testAddNote()
    {
        
        $note = 'CUSTOM-NOTE: MY VCARD';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addNote(
                $note
            )
        );
    }

    public function testAddAddress()
    {
        $name = '';
        $extended = '';
        $street = 'Francisco Martins';
        $city = 'Porto Alegre';
        $region = 'RS';
        $zip = '91712-150';
        $country = 'BR';
        $type = 'HOME';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addAddress(
                $name,
                $extended,
                $street,
                $city,
                $region,
                $zip,
                $country,
                $type
            )
        );
    }


    public function testAddPhoto()
    {
        $photoJpg = __DIR__ .'/images/no-image.jpg';
        $photoPng = __DIR__ .'/images/no-image.png';
        $photoUrl = 'https://rogerscorrea.files.wordpress.com/2017/02/cropped-lego_p.jpg';

        // $this->assertEquals(
        //     $this->vcard, 
        //     $this->vcard->addPhoto(
        //         $photoJpg
        //     )
        // );

        // $this->assertEquals(
        //     $this->vcard, 
        //     $this->vcard->addPhoto(
        //         $photoPng
        //     )
        // );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addPhoto(
                $photoUrl
            )
        );
    }

    public function testAddSocialProfile()
    {
        $socialProfile1 = 'https://facebook.com/';
        $typeSocialProfile1 = 'facebook';

        $socialProfile2 = 'https://instagram.com/';
        $typeSocialProfile2 = 'instagram';

        $socialProfile3 = 'https://twitter.com/';
        $typeSocialProfile3 = 'twitter';

        $socialProfile4 = 'https://linkedin.com/';
        $typeSocialProfile4 = 'linkedin';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addSocialProfile(
                $socialProfile1,
                $typeSocialProfile1
            )
        );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addSocialProfile(
                $socialProfile2,
                $typeSocialProfile2
            )
        );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addSocialProfile(
                $socialProfile3,
                $typeSocialProfile3
            )
        );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addSocialProfile(
                $socialProfile4,
                $typeSocialProfile4
            )
        );
    }

    public function testAddCustom()
    {
        $custom1 = 'X-CUSTOM(CHARSET=UTF-8,ENCODING=QUOTED-PRINTABLE,Custom1):1';
        $custom2 = 'X-CUSTOM(CHARSET=UTF-8,ENCODING=QUOTED-PRINTABLE,Custom2):2';

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addCustom(
                $custom1
            )
        );

        $this->assertEquals(
            $this->vcard, 
            $this->vcard->addCustom(
                $custom2
            )
        );
    }

    public function testGenerateVCard()
    {
        $vcard = new VCard();

        $vcard->addPhoto(__DIR__ .'/images/rogerscorrea.jpg');

        $lastName = 'Corrêa';
        $firstName = 'Rogers';
        $additional = '';
        $prefix = '';
        $suffix = '';

        $vcard->addnames(
                $lastName, 
                $firstName, 
                $additional, 
                $prefix, 
                $suffix
        );

        $vcard->addPhone('+5551999999999', 'CELL');

        $vcard->addPhone('+555133333333', 'HOME');

        $vcard->addRole('Developer');

        $vcard->addEmail('rogersgbc@gmail.com');

        $vcard->addCompany('XYZ');

        $vcard->addUrl('http://rogerscorrea.wordpress.com');

        $vcard->addUrl('https://github.com/rogersxd');

        $vcard->addNote('CUSTOM-NOTE: TEST VCARD');

        $name = '';
        $extended = '';
        $street = 'Francisco Martins, 123';
        $city = 'Porto Alegre';
        $region = 'RS';
        $zip = '91712-150';
        $country = 'BR';
        $type = 'HOME';

        $vcard->addAddress(
            $name,
            $extended,
            $street,
            $city,
            $region,
            $zip,
            $country,
            $type
        );

        $socialProfile1 = 'https://facebook.com/';
        $typeSocialProfile1 = 'facebook';

        $socialProfile2 = 'https://instagram.com/';
        $typeSocialProfile2 = 'instagram';

        $socialProfile3 = 'https://twitter.com/';
        $typeSocialProfile3 = 'twitter';

        $socialProfile4 = 'https://linkedin.com/';
        $typeSocialProfile4 = 'linkedin';

        $vcard->addSocialProfile(
            $socialProfile1,
            $typeSocialProfile1
        );

        $vcard->addSocialProfile(
            $socialProfile2,
            $typeSocialProfile2
        );

        $vcard->addSocialProfile(
            $socialProfile3,
            $typeSocialProfile3
        );

        $vcard->addSocialProfile(
            $socialProfile4,
            $typeSocialProfile4
        );

        $vcard->addCustom('X-CUSTOM(CHARSET=UTF-8,ENCODING=QUOTED-PRINTABLE,Custom1):1');

        $vcard->setSavePath(__DIR__. '/vcf/');

        $vcard->save();
    }
}