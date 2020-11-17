<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreatIntelligenceInfo extends Model
{
    //
    protected $table = 'threat_intelligence_info';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'heading', 'description', 'url', 'variant'
    ];
}
