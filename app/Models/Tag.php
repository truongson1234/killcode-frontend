<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Phpml\FeatureExtraction\StopWords;
// use Phpml\Tokenization\WhitespaceTokenizer;
// use Phpml\FeatureExtraction\TfIdfTransformer;
// use Phpml\FeatureExtraction\TokenCountVectorizer;
// use Phpml\Math\Distance\Cosine;
// use Phpml\ModelManager;
// use Phpml\NeuralNetwork\Layer;
// use Phpml\NeuralNetwork\Node\Neuron;
// use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
// use Phpml\NeuralNetwork\ActivationFunction\HyperbolicTangent;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followed_tags', 'tag_id', 'user_id');
    }
}
