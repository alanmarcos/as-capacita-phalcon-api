<?php
namespace App\Filmes\Controllers;

use App\Controllers\RESTController;
use App\Filmes\Models\Filmes;

class FilmesController extends RESTController
{

    public function getFilmes()
    {
        try {
            $filmes = (new Filmes())->find(
                [
                    'conditions' => 'true ' . $this->getConditions(),
                    'columns' => $this->partialFields,
                    'limit' => $this->limit
                ]
            );

            return $filmes;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getFilme($filmeId)
    {
        try {
            $filmes = (new Filmes())->findFirst(
                [
                    'conditions' => "filmeId = '$filmeId'",
                    'columns' => $this->partialFields,
                ]
            );

            return $filmes;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }        
    }

    public function addFilme()
    {
        try {
            $filme = new Filmes();
            $filme->sName = $this->di->get('request')->getPost('sName');
            $filme->sYear = $this->di->get('request')->getPost('sYear');
            $filme->imdbId = $this->di->get('request')->getPost('imdbId');

            $filme->saveDB();

            return $filme;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        
    }

    public function editFilme($filmeId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $filme = (new Filmes())->findFirst($filmeId);

            if (false === $filme) {
                throw new \Exception("Esse filme não existe em nosso banco de dados.", 200);
            }

            $filme->sName = isset($put['sName']) ? $put['sName'] : $filme->sName;
            $filme->sYear = isset($put['sYear']) ? $put['sYear'] : $filme->sYear;
            $filme->imdbId = isset($put['imdbId']) ? $put['imdbId'] : $filme->imdbId;

            $filme->saveDB();

            return $filme;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteFilme($filmeId)
    {
        try {

            $filmes = (new Filmes)->findFirst($filmeId);

            if(false === $filmes){
                throw new Exception("Esse filme não existe", 200);
            }

            return ['success' => $filmes->delete()];
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());            
        }
        
    }
}
