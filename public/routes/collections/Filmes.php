<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/filmes')
            ->setHandler('\App\Filmes\Controllers\FilmesController')
            ->setLazy(true);

        $userCollection->get('/', 'getFilmes');
        $userCollection->get('/{id:\d+}', 'getFilme');

        $userCollection->post('/', 'addFilme');

        $userCollection->put('/{id:\d+}', 'editFilme');

        $userCollection->delete('/{id:\d+}', 'deleteFilme');

        return $userCollection;
    }
);
