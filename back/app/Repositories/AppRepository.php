<?php

namespace App\Repositories;

class AppRepository
{
    public static function mask($valor, $mask)
    {
        $maskared = '';
        $positionValor = 0;
        for ($positionMask = 0; $positionMask < strlen($mask); $positionMask++) {
            if ($mask[$positionMask] == '#') {
                $maskared .= $valor[$positionValor++];
            } elseif ($mask[$positionMask] == '*') {
                $maskared .= $mask[$positionMask];
                $positionValor++;
            } else {
                $maskared .= $mask[$positionMask];
            }
        }
        return $maskared;
    }

    public static function EncryptIds($dados)
    {
        $decode = json_decode($dados);
        if ($decode) {
            return json_encode(AppRepository::maskIds($decode));
        } else {
            return $dados;
        }
    }

    public static function DecryptIds($dados)
    {
        if ($dados) {
            if (is_string($dados)) {
                $dados = json_decode($dados);
            }
            return json_encode(AppRepository::unMaskIds($dados));
        }
    }

    private static function maskIds($dados)
    {
        $dados = json_decode(json_encode($dados));
        if (is_array($dados) || is_object($dados)) {
            $dados = collect($dados);
            $dados->transform(function ($item, $key) {
                if (preg_match('/^(id)$|(_id)$/i', $key) && $item && !is_array($item)) {
                    return base64_encode(str_rot13(base64_encode(convert_uuencode(strrev(base_convert($item, 10, 3))))));
                }
                return AppRepository::maskIds($item);
            });
        }
        return $dados;
    }

    private static function unMaskIds($dados)
    {
        $dados = json_decode(json_encode($dados));
        if (is_array($dados) || is_object($dados)) {
            $dados = collect($dados);
            $dados->transform(function ($item, $key) {
                if (preg_match('/^(id)$|(_id)$/i', $key) && $item) {
                    return base_convert((strrev(convert_uudecode(base64_decode(str_rot13(base64_decode($item)))))), 3, 10);
                }
                return AppRepository::unMaskIds($item);
            });
        }
        return $dados;
    }

}
