<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Repositories\PenggunaRepository;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    protected PenggunaRepository $penggunaRepository;

    public function __construct(PenggunaRepository $penggunaRepository)
    {
        $this->penggunaRepository = $penggunaRepository;
    }

    public function index() {
        $penggunas = $this->penggunaRepository->getAllPengguna();

        return response([
            'success' => true,
            'message' => 'List pengguna',
            'data' => $penggunas
        ], 200);
    }

    public function store(Request $request) {
        $pengguna = $this->penggunaRepository->createPengguna($request);

        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'Item berhasil disimpan',
                'data' => $pengguna
            ],200);
        } else {
            return response([
				'success' => false,
				'message' => 'Item gagal disimpan',
			], 401);
        }
    }

    public function show($id) {
        $pengguna = $this->penggunaRepository->getPenggunaById($id);

        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'pengguna '. $id,
                'data' => $pengguna
            ],200);
        } else {
            return response([
				'success' => false,
				'message' => 'pengguna with id '. $id . ' not found',
			], 401);
        }
    }

    public function update(Request $request) {
        $pengguna = $this->penggunaRepository->updatePengguna($request);

        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'Item berhasil diupdate',
                'data' => $pengguna
            ],200);
        } else {
            return response([
				'success' => false,
				'message' => 'Item gagal diupdate',
			], 401);
        }
    }

    public function destroy($id) {
        $pengguna = $this->penggunaRepository->deletePengguna($id);

        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'Item berhasil dihapus'
            ],200);
        } else {
            return response([
				'success' => false,
				'message' => 'Item gagal dihapus',
			], 401);
        }
    }

    public function login(Request $request) {
      $pengguna = $this->penggunaRepository->getPenggunaByUsername($request->username);

      if($pengguna) {
          if($pengguna->password == $request->password) {
            $pengguna->password = "";
            return response([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [$pengguna]
            ],200);
          } else {
            return response([
                'success' => false,
                'message' => 'Password salah',
                'data' => []
            ],200);
          }
      } else {
        return response([
            'success' => false,
            'message' => 'Username tidak ditemukan',
            'data' => []
        ], 200);
      }
    }

    public function getPenggunaStaff($id_user) {
        $data = array();
        $penggunas = $this->penggunaRepository->getListStaff($id_user);


        if($penggunas) {
            return response([
                'success' => true,
                'message' => 'List Staff',
                'data' => $penggunas
            ],200);
        } else {
            return response([
				'success' => false,
				'message' => 'No staff data',
			], 401);
        }
    }

    public function getPenggunaByIdPosition($id_position) {
        $pengguna = $this->penggunaRepository->getPenggunaByPositionId($id_position);

        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'pengguna with position'. $id_position,
                'data' => $pengguna
            ],200);
        } else {
            return response([
				'success' => false,
				'message' => 'pengguna with id position '. $id_position . ' not found',
			], 401);
        }
    }

    public function uploadFotoPengguna(Request $request) {
        $path = Storage::putFile('public/foto', $request->file('foto'));
        $path = substr($path,7);

        $pengguna = $this->penggunaRepository->updateFoto($request->id,  $path);

        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'upload foto berhasil',
                'data' => $path
            ], 200);
        } else {
            return response([
                'success' => false,
                'message' => 'upload foto gagal',
                'data' => []
            ], 200);
        }
    }

    public function getFotoPengguna($id_user) {
        $pengguna = $this->penggunaRepository->getFotoPengguna($id_user);
        if($pengguna) {
            return response([
                'success' => true,
                'message' => 'upload foto berhasil',
                'data' => $pengguna->foto
            ], 200);
        } else {
            return response([
                'success' => false,
                'message' => 'upload foto gagal',
                'data' => []
            ], 200);
        }
    }
}
