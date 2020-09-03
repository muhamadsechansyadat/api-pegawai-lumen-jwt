<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $status = "";
        if ($this->status == 1) {
            $status = "Karyawan tetap";
        } else if ($this->status == 2) {
            $status = "Kontrak";
        } else {
            $status = "Keluar";
        }
        return [
            'id' => $this->id,
            'company' => $this->company->name,
            'division' => $this->division->name,
            'religion' => $this->religion->name,
            'country' => $this->country->name,
            'nip' => $this->nip,
            'name' => $this->name,
            'gender' => ($this->gender=="L")?"Laki-Laki":"Perempuan",
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'date_birth' => $this->date_birth,
            'date_join' => $this->date_join,
            'photo_profile' => url('files/'.$this->photo_profile),
            'status' => $status,
            'level' => $this->level,
        ];
    }
}
