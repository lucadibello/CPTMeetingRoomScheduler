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
            $attr = array("givenName","sn","mail","memberof");
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
            // invalid name or password
            return false;
        }
    }
}