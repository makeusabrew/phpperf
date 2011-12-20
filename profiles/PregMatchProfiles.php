<?php

class PregMatchProfiles implements IProfile {
    public function getTitle() {
        return "PCRE methods";
    }

    public function profilePregMatch() {
        preg_match("/^(.+)$/", "test");
    }

    public function profilePregMatchStoreMatches() {
        preg_match("/^(.+)$/", "test", $matches);
    }

    /**
     * @label preg_match() with typical postcode
     */
    public function profilePregMatchPostcode() {
        preg_match("#^(GIR 0AA)|(((A[BL]|B[ABDHLNRSTX]?|C[ABFHMORTVW]|D[ADEGHLNTY]|E[HNX]?|F[KY]|G[LUY]?|H[ADGPRSUX]|I[GMPV]|JE|K[ATWY]|L[ADELNSU]?|M[EKL]?|N[EGNPRW]?|O[LX]|P[AEHLOR]|R[GHM]|S[AEGKLMNOPRSTY]?|T[ADFNQRSW]|UB|W[ADFNRSV]|YO|ZE)[1-9]?[0-9]|((E|N|NW|SE|SW|W)1|EC[1-4]|WC[12])[A-HJKMNPR-Y]|(SW|W)([2-9]|[1-9][0-9])|EC[1-9][0-9]) [0-9][ABD-HJLNP-UW-Z]{2})$#i", "LS1 3EX");
    }

    public function profilePregReplace() {
        preg_replace('/(\w+) (\d+), (\d+)/i', '${1}1,$3', 'April 15, 2003');
    }
}
