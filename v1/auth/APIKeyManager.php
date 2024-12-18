<?php
namespace MyApp\Auth;

class APIKeyManager {
    private ;

    public function __construct() {
        ->db = ;
    }

    public function generateToken() {
         = random_int(PHP_INT_MIN, PHP_INT_MAX);
         = random_int(PHP_INT_MIN, PHP_INT_MAX);
         = sprintf('%016x%016x', , );
        return ->base22Encode(substr(, 0, 32));
    }

    private function base22Encode() {
         = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
         = hex2bin();
         = '';
         = strlen();
        for ( = 0;  < ;  += 4) {
             = substr(, , 4);
             = unpack('N', str_pad(, 4, "\0", STR_PAD_LEFT))[1];
            for ( = 0;  < 5; ++) {
                 .= [ % 22];
                 = intdiv(, 22);
            }
        }
        return ;
    }

    public function issueNewToken() {
         = ->generateToken();
         = ->db->prepare("INSERT INTO active_tokens (user_id, token) VALUES (?, ?)");
        ->bind_param("is", , );
        ->execute();
        return ;
    }

    public function invalidateToken() {
         = ->db->prepare("DELETE FROM active_tokens WHERE token = ?");
        ->bind_param("s", );
        ->execute();

         = ->db->prepare("INSERT INTO dead_tokens (token) VALUES (?)");
        ->bind_param("s", );
        ->execute();

        ->updateAssociatedRecords();
    }

    private function updateAssociatedRecords() {
         = ['order_list', 'item_list'];
        foreach ( as ) {
             = ->db->prepare("SELECT id, user_id FROM  WHERE token = ?");
            ->bind_param("s", );
            ->execute();
             = ->get_result();
            while ( = ->fetch_assoc()) {
                 = ->issueNewToken(['user_id']);
                 = ->db->prepare("UPDATE  SET token = ? WHERE id = ?");
                ->bind_param("si", , ['id']);
                ->execute();
            }
        }
    }

    public function isTokenValid() {
         = ->db->prepare("SELECT 1 FROM active_tokens WHERE token = ?");
        ->bind_param("s", );
        ->execute();
         = ->get_result();
        return ->num_rows > 0;
    }
}
