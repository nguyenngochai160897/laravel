<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use DB;

class JobController extends Controller
{
    function getDom($link){
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: G_AUTHUSER_H=0; _ga=GA1.2.1679938339.1563851522; _gid=GA1.2.242136086.1563851522; cvmissing=value; _gcl_au=1.1.777702999.1563851523; G_ENABLED_IDPS=google; _fbp=fb.1.1563851525396.2059433505; _gcl_aw=GCL.1563853218.Cj0KCQjwvdXpBRCoARIsAMJSKqI77mcb-jKipo64ygwGXrowMtig6V1AogQJMJmPb88vNEijpFpLpgAaAn8vEALw_wcB; _gac_UA-42033311-1=1.1563853218.Cj0KCQjwvdXpBRCoARIsAMJSKqI77mcb-jKipo64ygwGXrowMtig6V1AogQJMJmPb88vNEijpFpLpgAaAn8vEALw_wcB; _gac_UA-42033311-2=1.1563853218.Cj0KCQjwvdXpBRCoARIsAMJSKqI77mcb-jKipo64ygwGXrowMtig6V1AogQJMJmPb88vNEijpFpLpgAaAn8vEALw_wcB; _gac_UA-42033311-4=1.1563853218.Cj0KCQjwvdXpBRCoARIsAMJSKqI77mcb-jKipo64ygwGXrowMtig6V1AogQJMJmPb88vNEijpFpLpgAaAn8vEALw_wcB; auto_promote_submit_review=true; remember_user_token=W1syNTM1NDldLCIkMmEkMTAkdk5XdG5FRXpwQU5rNHMyTkozQi9kZSIsIjE1NjM4Njc3NTkuMTUyMDg5OCJd--b7a8fe03d913dd6bc941ea675481354d85dba9e3; G_AUTHUSER_H=0; uvts=819919df-26f9-49c8-4efd-fcee722e67c5; recent_searches=; _gat=1; _dc_gtm_UA-42033311-2=1; _dc_gtm_UA-42033311-4=1; _ITViec_session=OWFkVFpWcW9pMWp5WWFUbnlZWFRmU2pCNUJoYW1yQlVkVWxPVy8wdHJTK1MzYUtLd2xDZ2Q2elUyWExRRmxVaEpZS3pYcWRqZ3FGcFdqVm82cHJ2Tks3dFNEYW55UkRHeW51WGpjNUtSalM1d0lwZDVxZitmRkU4M0FsdDVORXo0VDFFcytlbzREOS91aE5TaklCSkttT1djY241VGpzcnVHT3psYnl0V0ZCRnMxVGU5alNKVlB1bllsbGhTRzZhOXBLR1MwbFh2Yjd6Kzg4TkNXSVdmT2dmUDYyNHBReHZzK0dudk8wOHpITGQ5NStoVGJaZlQxT044QXhhUnkxWHNucmRUQjJUNEdtc1JxS3c1Z3BrZXc9PS0tbE1xQndGVTVkMkFDcWw2WlJaWWZwZz09--c3797059a85d8250b7f90d47a31dfd5df5aff0df; fbm_403551049745808=base_domain=.itviec.com; fbsr_403551049745808=7XygqvGDPOGTchUScEh5rSg6cAE0ZTzlPybcn9ZmfjM.eyJjb2RlIjoiQVFDWWY0QTdGcDBVeGdxbzBZQ1VmOGsta0xObUhZTlVMSDdBV18zRUtJbFBNRnQtZ3ZZV00wLWFub3FiUFBwbUZFbkthcVBLN0RtSmJtYVRJa2J3OU1zYzhyT0txSzdrczlyWG5Xamp2VzhWTGM2R1ZLXy1UaFpkSE5JNUR2VHNpcHpWQUoxaXljc3J3aFlSVUdiU3RCLXFhQTFIR0FjbDZSMGxKZWVfaHFwT0EyZ2FJODFLWGN6ekw3c2tfbEZubEpwTDdVWXh5QjJqR0pLRjlrSkZiWHB2MG03X2VpNkRfRllDSElzcExhSDN0ZmhYMmxiRWtiTGo4SHV5X3hFT29WSVpUZE5pOUg3VWltVE55aEtTbGxLZGVQSzdRdndhXzc0eHJiMVRydlBtWExXLTRvREljUU91OEtvTDNTSy1zbGQxZE1sOUJMOEFyanhtNjZIWXFrSkgiLCJ1c2VyX2lkIjoiNDU2MDA1MDUxNDAzNDQ1IiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE1NjM4NzA3NzZ9"));
        $content = curl_exec($ch);
        curl_close($ch);
        $dom = HtmlDomParser::str_get_html($content);
        return $dom;
    }
    function getCompany(){
        $html = $this->getDom("https://itviec.com/jobs-company-index");
        $result = array();
        foreach($html->find('.skill-tag__link') as $element){
            $url_detail = "https://itviec.com".$element->href;
            $resource = $url_detail;
            $company = $element->plaintext;
            $html_detail = $this->getDom($url_detail);
            $num_emps = trim($html_detail->find(".group-icon", 0)->plaintext);
            $market = trim($html_detail->find(".country .name", 0)->plaintext);
            $address = trim($html_detail->find(".fa-map-marker", 0)->plaintext);
            $address_details = array();
            foreach($html_detail->find(".full-address-mobile") as $add){
                array_push($address_details, trim($add->plaintext));
            }
            $jobs = array();
            $job_names = array();
            $job_salarys = array();
            foreach($html_detail->find(".title") as $job){
                array_push($job_names, trim($job->plaintext));
            }
            foreach($html_detail->find(".salary-text") as $job){
                array_push($job_salarys, trim($job->plaintext));
            }
            for ($i=0; $i < count($job_names); $i++) { 
                array_push($jobs, array(
                    "name" => $job_names[$i],
                    "salary" => $job_salarys[$i],
                ));
            }
            dd($jobs);
            array_push($result, array(
                "resource" =>$resource,
                "name" => $company,
                "num_employees" => $num_emps,
                "market" => $market,
                "address" => $address,
                "address_detail" => implode("|", $address_details),
                "jobs" => $jobs
            ));

            dd($result);
            
            break;
        }
        //save db
        foreach($result as $r){
            DB::insert("insert into companies (resource, name, num_employees, market, address, address_detail, jobs, salary) values(?, ?, ?, ?, ?, ?, ?, ?)",
            [$r['resource'], $r['name'], $r['num_employees'], $r['market'], $r]
        ); 
        }
    }   
}
