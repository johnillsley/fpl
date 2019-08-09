<?php
echo Form::open(array('url' => 'foo/bar','method' => 'PUT'));
        
echo Form::select("position",['1' => 'Goalkeeper', '2' => 'Defender', '3' => 'Midfielder', '4' => 'Forward'], $position,
        [
                "class" => "form-group",
                "placeholder" => "Position..."
        ]):

// Team

// Watchlist only

// Min value

// Max value



echo Form::submit('Submit form');

echo Form::close();