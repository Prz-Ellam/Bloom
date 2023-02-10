<?php

namespace Bloom\Database\Factory;

enum ConnectionType : string {
    case PDO = "PDO";
    case MYSQLI = "MYSQLI";
}
