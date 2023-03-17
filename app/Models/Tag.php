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

    // public function getSimilarTags($tag, $num_tags = 5)
    // {
    //     // Load the trained model from file
    //     $filepath = storage_path('app/word2vec.model');
    //     $modelManager = new ModelManager();
    //     $word2vec = $modelManager->restoreFromFile($filepath);

    //     // Tokenize the input tag and remove stop words
    //     $tokenizer = new WhitespaceTokenizer();
    //     $stopWords = new StopWords();
    //     $tokens = array_diff($tokenizer->tokenize($tag), $stopWords->getStopWords());

    //     // Calculate the vector representation of the input tag
    //     $vectorizer = new TokenCountVectorizer($tokens);
    //     $vectorizer->fit($tokens);
    //     $vector = $vectorizer->transform($tokens);

    //     // Find the most similar tags using cosine distance
    //     $similarTags = [];
    //     $cosine = new Cosine();
    //     foreach ($word2vec->getVocabulary() as $v) {
    //         $similarity = $cosine->distance($word2vec->transform([$tag])[0], $word2vec->transform([$v])[0]);
    //         $similarTags[$v] = $similarity;
    //     }

    //     // Sort the tags by similarity and return the top n tags
    //     arsort($similarTags);
    //     $similarTags = array_slice($similarTags, 0, $num_tags, true);

    //     return array_keys($similarTags);
    // }
    // cách dùng 
    // $tag = 'laravel';
    // $num_tags = 5;
    // $similarTags = (new Tag())->getSimilarTags($tag, $num_tags);
    // print_r($similarTags);
}
