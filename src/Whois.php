<?php

namespace Sayeed\Whois;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Pdp\Rules;

class Whois
{
    /**
     * Get whois information for a domain
     *
     * @param string $domain
     * @return string|array
     */
    public static function lookup(string $domain)
    {
        try {
			$domain = self::getRegisteredDomain($domain);
            $whois = shell_exec("whois " . escapeshellarg($domain));
			$whois_ln = explode("\n", $whois);
			$final_data = $data = [];
			foreach($whois_ln as $ln) {
				if(Str::contains($ln, ':')) {
					$ln = explode(':', $ln);
					$k = $ln[0];
					array_shift($ln);
					if(trim($k) == 'Name Server') {
						$i = isset($data[trim($k).'_1']) ? "_2" : "_1";
						$data[trim($k).$i] = trim(implode(':', $ln));
					} else {
						$data[trim($k)] = trim(implode(':', $ln));
					}
				}
			}
			$final_data['tld'] = $data['domain'] ?? '';
			$final_data['domain'] = $data['Domain Name'];
			$final_data['created'] = date('Y-m-d H:i:s', strtotime($data['Creation Date']));
			$final_data['updated'] = date('Y-m-d H:i:s', strtotime($data['Updated Date']));
			$final_data['expiry'] = date('Y-m-d H:i:s', strtotime($data['Registry Expiry Date']));
			$final_data['registrar'] = $data['Registrar'];
			$final_data['status'] = $data['status'] ?? 'ACTIVE';
			$final_data['name_server'] = [$data['Name Server_1'], $data['Name Server_2']];
			return $final_data;
        } catch (\Exception $e) {
            Log::error('Whois lookup failed: ' . $e->getMessage());
            return 'Error performing whois lookup';
        }
    }
	private static function getRegisteredDomain($domain) {
		$publicSuffixList = Rules::fromPath('https://publicsuffix.org/list/public_suffix_list.dat');
		$result = $publicSuffixList->resolve($domain);
		return $result->registrableDomain()->toString();
	}
}
