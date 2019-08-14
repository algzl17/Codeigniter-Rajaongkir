<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rajaongkir extends CI_Controller
{
    public function index()
    {
        $provinsi = $this->province();
        $data['province'] = $provinsi['rajaongkir']['results'];

        $this->load->view('rajaongkir', $data);
    }

    public function province()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 61a96032dc94eab1d8ae01f1fc904fb0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $hasil = json_decode($response, true);
            return $hasil;
        }
    }

    public function kabupaten()
    {
        $prov = $this->input->get('prov_id');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$prov",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 61a96032dc94eab1d8ae01f1fc904fb0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            $kab = $data['rajaongkir']['results'];
            for ($i = 0; $i < count($kab); $i++) {
                echo "<option value='" . $kab[$i]['city_id'] . "'>" . $kab[$i]['city_name'] . "</option>";
            }
        }
    }

    public function ongkir()
    {
        // Set Kota asal
        $asal = 419; //kota sleman (419)

        $tujuan = $this->input->post('kab_id');
        $berat = $this->input->post('weight');
        $kurir = $this->input->post('kurir');


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$asal&destination=$tujuan&weight=$berat&courier=$kurir",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 61a96032dc94eab1d8ae01f1fc904fb0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            $ongkir = $data['rajaongkir']['results'][0]['costs'];
            for ($i = 0; $i < count($ongkir); $i++) {
                echo "<option value='" .  $ongkir[$i]['cost'][0]['value'] . "'>" . $ongkir[$i]['service'] . " - Rp." . $ongkir[$i]['cost'][0]['value'] . "</option>";
            }
        }
    }
}
        
    /* End of file  Rajaongkir.php */
