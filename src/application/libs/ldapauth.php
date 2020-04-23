<?php
/**
 * Created by PhpStorm.
 * User: luca6
 * Date: 19.09.2019
 * Time: 14:36
 */

class LdapAuth
{
    function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    function auth()
    {
        $ed = new EnDecrypt();

        // Salvo l'indirizzo del server LDAP
        $host = "http://212.117.109.242:1935/autenticami_esterno_2016.php?";

        // Salvo l'username passato dal form di login
        $username = $ed->Encrypt_Text($this->username);

        // Salvo la password passata dal form di login
        $password = $ed->Encrypt_Text($this->password);

        // URL parameters
        $parameters = http_build_query([
            'u' => $username,
            'p' => $password,
            'chi' => 'cpt'
        ], '', '&');

        var_dump($parameters);

        // Initialize CURL
        $ch = curl_init();

        // Set options on curl request
        curl_setopt($ch, CURLOPT_URL, $host . $parameters);
        curl_setopt($ch, CURLOPT_HEADER, 0); // get the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

        // Execute CURL request
        $response = curl_exec($ch);

        // Close CURL connection
        curl_close($ch);

        // If the response hasn't returned a valid response
        if (is_null($response) || $response === "" || !$response) {
            // Returns to the login with a error
            echo "Non è stata ritornata nessuna risposta dal server. Contattare un amminsitratore";
            return false;
        } else {
            // Expldes response data
            $response = explode('&', $response);

            // Initialize an array for value key pair
            $data = [];

            // For each response element
            foreach ($response as $value) {
                $kv = explode('=', $value);
                $data[$kv[0]] = $kv[1];
            }

            if ((!isset($data['appartenenza']) || ($data['appartenenza'] !== "DOCENTE" && $data['appartenenza'] !== "DOCENTI" && $data['appartenenza'] !== "DIREZIONE" && $data['appartenenza'] !== "AMMINISTRAZIONE" && $data['appartenenza'] !== "CUSTODI" && $data['appartenenza'] !== "AMMINISTRATORE") || strcmp($data['username'], $this->username) !== 0)){
                return false;
            }
            else {
                $fullname = explode($this->username, ".");

                return new LdapUser(
                    $this->username,
                    $fullname[0],
                    $fullname[1],
                    $data["email"]
                );
            }
        }
    }

    function local_auth()
    {
        $user = $this->username;
        $password = $this->password;

        if (empty($user) || empty($password)) return false;

        // active directory server
        $ldap_host = LDAP_HOST;

        // active directory DN (base location of ldap search)
        $ldap_dn = LDAP_USER_DN_GROUP;

        // active directory user group name
        $ldap_docenti_group = LDAP_AUTHORIZED_USER_GROUP;

        // domain, for purposes of constructing $user
        $ldap_usr_dom = '@cpt.local';

        // connect to active directory
        $ldap = ldap_connect($ldap_host);

        // configure ldap params
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        // verify user and password
        if (@ldap_bind($ldap, $user . $ldap_usr_dom, $password)) {
            // check presence in groups
            $filter = "(sAMAccountName=" . $user . ")";
            $attr = array("givenName", "sn", "mail", "memberof");
            $result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search on LDAP server");
            $entries = ldap_get_entries($ldap, $result);
            ldap_unbind($ldap);

            $access = false;

            if ($entries["count"] != 0) {
                foreach ($entries[0]['memberof'] as $grps) {
                    // is in 'docente' group, break loop
                    if (strpos($grps, $ldap_docenti_group)) {
                        $access = True;
                        break;
                    }
                }

                if ($access) {
                    // User found: getting personal informations

                    // Read user infos
                    $data = $entries[0];
                    $firstname = $data["givenname"][0];
                    $surname = $data["sn"][0];
                    $email = $data["mail"][0];

                    // Build LdapUser object
                    $user = new LdapUser(
                        $this->username,
                        $firstname,
                        $surname,
                        $email
                    );

                    // return object
                    return $user;
                } else {
                    // user has no rights
                    return false;
                }
            } else {
                // No data found in AD
                return false;
            }
        } else {
            // invalid name or password / connection error
            return false;
        }
    }
}