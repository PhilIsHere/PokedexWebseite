<?php
namespace App;

use App\traits\ArrayTraits;

class User {

    use ArrayTraits;

    private string $vorname;
    private string $username;
    private string $nachname;
    private string $email;
    private string $passwort;
    private string $inputUsername;
    private string $inputPasswort;

    /**
     * @return string
     */
    public function getVorname(): string
    {
        return $this->vorname;
    }

    /**
     * @param string $vorname
     */
    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getNachname(): string
    {
        return $this->nachname;
    }

    /**
     * @param string $nachname
     */
    public function setNachname(string $nachname): void
    {
        $this->nachname = $nachname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPasswort(): string
    {
        return $this->passwort;
    }

    /**
     * @param string $passwort
     */
    public function setPasswort(string $passwort): void
    {
        $this->passwort = $passwort;
    }


}