<?php

namespace Rafwell\Focusnfe\Enums;

enum AmbienteNfse: string {

    case MUNICIPAL = 'municipal';
    case NACIONAL  = 'nacional';

    public static function default(): self {
        return self::MUNICIPAL;
    }

    public function endpoint(): string {
        return match ($this) {
            self::MUNICIPAL => '/v2/nfse/',
            self::NACIONAL  => '/v2/nfsen/',
        };
    }
}
