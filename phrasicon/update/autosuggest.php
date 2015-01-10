
<?php

interface TokenizerInterface
{
    /**
     * Break a character sequence to a token sequence
     *
     * @param  string $str The text for tokenization
     * @return array  The list of tokens from the string
     */
    public function tokenize($str);
}
?>
<?php

/**
 * Simple white space tokenizer.
 * Break on every white space
 */
class WhitespaceTokenizer implements TokenizerInterface
{
    const PATTERN = '/[\pZ\pC]+/u';

    public function tokenize($str)
    {
        $arr = array();

        return preg_split(self::PATTERN,$str,null,PREG_SPLIT_NO_EMPTY);
    }
}

?>

<?php


interface FeatureBasedLinearOptimizerInterface
{
    /**
     * This function receives an array that contains an array for
     * each document which contains an array of feature identifiers for
     * each class and at the special key '__label__' the actual class
     * of the training document.
     *
     * As a result it contains all the information needed to train a
     * set of weights with any target. Ex.: If we were training a maxent
     * model we would try to maximize the CLogLik that can be calculated
     * from this array.
     *
     * @param  array &$feature_array
     * @return array The parameteres $l
     */
    public function optimize(array &$feature_array);
}
?>
<?php

/**
 * Implements gradient descent with fixed step.
 * Leaves the computation of the fprime to the children classes.
 */
abstract class GradientDescentOptimizer implements FeatureBasedLinearOptimizerInterface
{
    // gradient descent parameters
    protected $precision; // how close to zero should fprime go
    protected $step; // learning rate
    protected $maxiter; // maximum iterations (-1 for "infinite")

    // array that holds the current fprime
    protected $fprime_vector;

    // report the improvement
    protected $verbose=2;

    public function __construct($precision=0.001, $step=0.1, $maxiter = -1)
    {
        $this->precision = $precision;
        $this->step = $step;
        $this->maxiter = $maxiter;
    }

    /**
     * Should initialize the weights and compute any constant
     * expressions needed for the fprime calculation.
     *
     * @param $feature_array All the data known about the training set
     * @param $l The current set of weights to be initialized
     * @return void
     */
    abstract protected function initParameters(array &$feature_array, array &$l);
    /**
     * Should calculate any parameter needed by Fprime that cannot be
     * calculated by initParameters because it is not constant.
     *
     * @param $feature_array All the data known about the training set
     * @param $l The current set of weights to be initialized
     * @return void
     */
    abstract protected function prepareFprime(array &$feature_array, array &$l);
    /**
     * Actually compute the fprime_vector. Set for each $l[$i] the
     * value of the partial derivative of f for delta $l[$i]
     *
     * @param $feature_array All the data known about the training set
     * @param $l The current set of weights to be initialized
     * @return void
     */
    abstract protected function Fprime(array &$feature_array, array &$l);

    /**
     * Actually do the gradient descent algorithm.
     * l[i] = l[i] - learning_rate*( theta f/delta l[i] ) for each i
     * Could possibly benefit from a vetor add/scale function.
     *
     * @param $feature_array All the data known about the training set
     * @return array The parameters $l[$i] that minimize F
     */
    public function optimize(array &$feature_array)
    {
        $itercount = 0;
        $optimized = false;
        $maxiter = $this->maxiter;
        $prec = $this->precision;
        $l = array();
        $this->initParameters($feature_array,$l);
        while (!$optimized && $itercount++<$maxiter) {
            //$start = microtime(true);
            $optimized = true;
            $this->prepareFprime($feature_array,$l);
            $this->Fprime($feature_array,$l);
            foreach ($this->fprime_vector as $i=>$fprime_i_val) {
                $l[$i] -= $fprime_i_val;
                if (abs($fprime_i_val) > $prec) {
                    $optimized = false;
                }
            }
            //fprintf(STDERR,"%f\n",microtime(true)-$start);
            if ($this->verbose>0)
                $this->reportProgress($itercount);
        }

        return $l;
    }

    public function reportProgress($itercount)
    {
        if ($itercount == 1) {
            //echo "#\t|Fprime|\n------------------\n";
        }
        $norm = 0;
        foreach ($this->fprime_vector as $fprime_i_val) {
            $norm += $fprime_i_val*$fprime_i_val;
        }
        $norm = sqrt($norm);
        //printf("%d\t%.3f\n",$itercount,$norm);
    }
}
?>
<?php


/**
 * Marker interface to use with the Maxent model for type checking
 */
interface MaxentOptimizerInterface extends FeatureBasedLinearOptimizerInterface {}

?>
<?php

/**
 * Implement a gradient descent algorithm that maximizes the conditional
 * log likelihood of the training data.
 *
 * See page 24 - 28 of http://nlp.stanford.edu/pubs/maxent-tutorial-slides.pdf
 * @see NlpTools\Models\Maxent
 */

class MaxentGradientDescent extends GradientDescentOptimizer implements MaxentOptimizerInterface
{
    // will hold the constant numerators
    protected $numerators;
    // denominators will be computed on each iteration because they
    // depend on the weights
    protected $denominators;

    /**
     * We initialize all weight for any feature we find to 0. We also
     * compute the empirical expectation (the count) for each feature in
     * the training data (which of course remains constant for a
     * specific set of data).
     *
     * @param $feature_array All the data known about the training set
     * @param $l The current set of weights to be initialized
     * @return void
     */
    protected function initParameters(array &$feature_array, array &$l)
    {
        $this->numerators = array();
        $this->fprime_vector = array();
        foreach ($feature_array as $doc) {
            foreach ($doc as $class=>$features) {
                if (!is_array($features)) continue;
                foreach ($features as $fi) {
                    $l[$fi] = 0;
                    $this->fprime_vector[$fi] = 0;
                    if (!isset($this->numerators[$fi])) {
                        $this->numerators[$fi] = 0;
                    }
                }
            }
            foreach ($doc[$doc['__label__']] as $fi) {
                $this->numerators[$fi]++;
            }
        }
    }

    /**
     * Compute the denominators which is the predicted expectation of
     * each feature given a set of weights L and a set of features for
     * each document for each class.
     *
     * @param $feature_array All the data known about the training set
     * @param $l The current set of weights to be initialized
     * @return void
     */
    protected function prepareFprime(array &$feature_array, array &$l)
    {
        $this->denominators = array();
        foreach ($feature_array as $offset=>$doc) {
            $numerator = array_fill_keys(array_keys($doc),0.0);
            $denominator = 0.0;
            foreach ($doc as $cl=>$f) {
                if (!is_array($f)) continue;
                $tmp = 0.0;
                foreach ($f as $i) {
                    $tmp += $l[$i];
                }
                $tmp = exp($tmp);
                $numerator[$cl] += $tmp;
                $denominator += $tmp;
            }
            foreach ($doc as $class=>$features) {
                if (!is_array($features)) continue;
                foreach ($features as $fi) {
                    if (!isset($this->denominators[$fi])) {
                        $this->denominators[$fi] = 0;
                    }
                    $this->denominators[$fi] += $numerator[$class]/$denominator;
                }
            }
        }
    }

    /**
     * The partial Fprime for each i is
     * empirical expectation - predicted expectation . We need to
     * maximize the CLogLik (CLogLik is the f whose Fprime we calculate)
     * so we instead minimize the -CLogLik.
     *
     * See page 28 of http://nlp.stanford.edu/pubs/maxent-tutorial-slides.pdf
     *
     * @param $feature_array All the data known about the training set
     * @param $l The current set of weights to be initialized
     * @return void
     */
    protected function Fprime(array &$feature_array, array &$l)
    {
        foreach ($this->fprime_vector as $i=>&$fprime_i_val) {
            $fprime_i_val = $this->denominators[$i] - $this->numerators[$i];
        }
    }

}
?>
<?php

/**
 * TransformationInterface represents any type of transformation
 * to be applied upon documents. The transformation is defined upon
 * single values and how each document applies a transformation
 * differs. For instance TokensDocument should apply the transformation
 * on each token but EuclideanDocument could apply it on each key (dimension).
 *
 * There can be combinations of transformations and documents that make
 * no sense. For instance if we have a scaling transformation that expects
 * numeric values and returns them multiplied by a constant c, it
 * would make little sense to pass this transformation to
 * TokensDocument that expects transformations to be applied on
 * specific tokens.
 */
interface TransformationInterface
{
    /**
     * Return the value transformed.
     * @param  mixed $value The value to transform
     * @return mixed
     */
    public function transform($value);
}
?>
<?php


/**
 * A Document is a representation of a Document to be classified.
 * It can be a representation of a word, of a bunch of text, of a text
 * that has structure (ex.: Title,Body,Link)
 */
interface DocumentInterface
{
    /**
     * Return the data of what is being represented. If it were a word
     * we could return a word. If it were a blog post we could return
     * an array(Title,Body,array(Comments)).
     *
     * @return mixed
     */
    public function getDocumentData();

    /**
     * Apply the transformation to the data of this document.
     * How the transformation is applied (per token, per token sequence, etc)
     * is decided by the implementing classes.
     *
     * @param TransformationInterface $transform The transformation to be applied
     */
    public function applyTransformation(TransformationInterface $transform);
}
?>
<?php

/**
 * A TrainingDocument is a document that "decorates" any other document
 * to add the real class of the document. It is used while training
 * together with the training set.
 */
class TrainingDocument implements DocumentInterface
{
    protected $d;
    protected $class;

    /**
     * @param string            $class The actual class of the Document $d
     * @param DocumentInterface $d     The document to be decorated
     */
    public function __construct($class, DocumentInterface $d)
    {
        $this->d = $d;
        $this->class = $class;
    }
    public function getDocumentData()
    {
        return $this->d->getDocumentData();
    }
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Pass the transformation to the decorated document
     *
     * @param TransformationInterface $transform The transformation to be applied
     */
    public function applyTransformation(TransformationInterface $transform)
    {
        $this->d->applyTransformation($transform);
    }
}
?>
<?php 
class WordDocument implements DocumentInterface
{
    protected $word;
    protected $before;
    protected $after;
    public function __construct(array $tokens, $index, $context)
    {
        $this->word = $tokens[$index];

        $this->before = array();
        for ($start = max($index-$context,0);$start<$index;$start++) {
            $this->before[] = $tokens[$start];
        }

        $this->after = array();
        $end = min($index+$context+1,count($tokens));
        for ($start = $index+1;$start<$end;$start++) {
            $this->after[] = $tokens[$start];
        }
    }

    /**
     * It returns an array with the first element being the actual word,
     * the second element being an array of previous words, and the
     * third an array of following words
     *
     * @return array
     */
    public function getDocumentData()
    {
        return array($this->word,$this->before,$this->after);
    }

    /**
     * Apply the transformation to the token and the surrounding context.
     * Filter out the null tokens from the context. If the word is transformed
     * to null it is for the feature factory to decide what to do.
     *
     * @param TransformationInterface $transform The transformation to be applied
     */
    public function applyTransformation(TransformationInterface $transform)
    {
        $null_filter = function ($token) {
            return $token!==null;
        };

        $this->word = $transform->transform($this->word);
        // array_values for re-indexing
        $this->before = array_values(
            array_filter(
                array_map(
                    array($transform,"transform"),
                    $this->before
                ),
                $null_filter
            )
        );
        $this->after = array_values(
            array_filter(
                array_map(
                    array($transform,"transform"),
                    $this->after
                ),
                $null_filter
            )
        );
    }
}
?>

<?php

interface FeatureFactoryInterface
{
    /**
     * Return an array with unique strings that are the features that
     * "fire" for the specified Document $d and class $class
     *
     * @param  string            $class The class for which we are calculating features
     * @param  DocumentInterface $d     The document for which we are calculating features
     * @return array
     */
    public function getFeatureArray($class, DocumentInterface $d);
}

?>
<?php


/**
 * An implementation of FeatureFactoryInterface that takes any number of callables
 * (function names, closures, array($object,'func_name'), etc.) and
 * calls them consecutively using the return value as a feature's unique
 * string.
 *
 * The class can model both feature frequency and presence
 */
class FunctionFeatures implements FeatureFactoryInterface
{

    protected $functions;
    protected $frequency;

    /**
     * @param array $f An array of feature functions
     */
    public function __construct(array $f=array())
    {
        $this->functions=$f;
        $this->frequency=false;
    }
    /**
     * Set the feature factory to model frequency instead of presence
     */
    public function modelFrequency()
    {
        $this->frequency = true;
    }
    /**
     * Set the feature factory to model presence instead of frequency
     */
    public function modelPresence()
    {
        $this->frequency = false;
    }
    /**
     * Add a function as a feature
     *
     * @param callable $feature
     */
    public function add( $feature )
    {
        $this->functions[] = $feature;
    }

    /**
     * Compute the features that "fire" for a given class,document pair.
     *
     * Call each function one by one. Eliminate each return value that
     * evaluates to false. If the return value is a string add it to
     * the feature set. If the return value is an array iterate over it
     * and add each value to the feature set.
     *
     * @param  string            $class The class for which we are calculating features
     * @param  DocumentInterface $d     The document for which we are calculating features
     * @return array
     */
    public function getFeatureArray($class, DocumentInterface $d)
    {   
        
        $features = array_filter( // filters out all False values
            array_map( function ($feature) use ($class,$d) {  // array_map("myfunction", $array), here $feature = $this->functions[x]
                    return call_user_func_array($feature, array($class, $d)); // $feature is func, $class and $d are var
                },
                $this->functions
            ));
        $set = array();
        foreach ($features as $f) {
            if (is_array($f)) {
                foreach ($f as $ff) {
                    if (!isset($set[$ff]))
                        $set[$ff] = 0;
                    $set[$ff]++;
                }
            } else {
                if (!isset($set[$f]))
                    $set[$f] = 0;
                $set[$f]++;
            }
        }
        if ($this->frequency)
            return $set;
        else
            return array_keys($set);
    }

}
?>
<?php

/**
 * A collection of TrainingDocument objects. It implements many built
 * in php interfaces for ease of use.
 */
class TrainingSet implements \Iterator,\ArrayAccess,\Countable
{
    const CLASS_AS_KEY = 1;
    const OFFSET_AS_KEY = 2;

    // An array that contains all the classes present in the TrainingSet
    protected $classSet;
    protected $documents; // The documents container

    // When iterated upon what should the key be?
    protected $keytype;
    // When iterated upon the currentDocument
    protected $currentDocument;

    public function __construct()
    {
        $this->classSet = array();
        $this->documents = array();
        $this->keytype = self::CLASS_AS_KEY;
    }

    /**
     * Add a document to the set.
     *
     * @param $class The documents actual class
     * @param $d The Document
     * @return void
     */
    public function addDocument($class, DocumentInterface $d)
    {
        $this->documents[] = new TrainingDocument($class,$d);
        $this->classSet[$class] = 1;
    }
    // return the classset
    public function getClassSet()
    {
        return array_keys($this->classSet);
    }

    /**
     * Decide what should be returned as key when iterated upon
     */
    public function setAsKey($what)
    {
        switch ($what) {
            case self::CLASS_AS_KEY:
            case self::OFFSET_AS_KEY:
                $this->keytype = $what;
                break;
            default:
                $this->keytype = self::CLASS_AS_KEY;
                break;
        }
    }

    /**
     * Apply an array of transformations to all documents in this container.
     *
     * @param array An array of TransformationInterface instances
     */
    public function applyTransformations(array $transforms)
    {
        foreach ($this->documents as $doc) {
            foreach ($transforms as $transform) {
                $doc->applyTransformation($transform);
            }
        }
    }

    // ====== Implementation of \Iterator interface =========
    public function rewind()
    {
        reset($this->documents);
        $this->currentDocument = current($this->documents);
    }
    public function next()
    {
        $this->currentDocument = next($this->documents);
    }
    public function valid()
    {
        return $this->currentDocument!=false;
    }
    public function current()
    {
        return $this->currentDocument;
    }
    public function key()
    {
        switch ($this->keytype) {
            case self::CLASS_AS_KEY:
                return $this->currentDocument->getClass();
            case self::OFFSET_AS_KEY:
                return key($this->documents);
            default:
                // we should never be here
                throw new \Exception("Undefined type as key");
        }
    }
    // === Implementation of \Iterator interface finished ===

    // ====== Implementation of \ArrayAccess interface =========
    public function offsetSet($key,$value)
    {
        throw new \Exception("Shouldn't add documents this way, add them through addDocument()");
    }
    public function offsetUnset($key)
    {
        throw new \Exception("Cannot unset any document");
    }
    public function offsetGet($key)
    {
        return $this->documents[$key];
    }
    public function offsetExists($key)
    {
        return isset($this->documents[$key]);
    }
    // === Implementation of \ArrayAccess interface finished ===

    // implementation of \Countable interface
    public function count()
    {
        return count($this->documents);
    }
}
?>

<?php

/**
 * This class represents a linear model of the following form
 * f(x_vec) = l1*x1 + l2*x2 + l3*x3 ...
 *
 * Maybe the name is a bit off. What is really meant is that models of
 * this type provide a set of weights that will be used by the classifier
 * (probably through a linear combination) to decide the class of a
 * given document.
 *
 */
class LinearModel
{
    protected $l;
    public function __construct(array $l)
    {
        $this->l = $l;
    }
    /**
     * Get the weight for a given feature
     *
     * @param  string $feature The feature for which the weight will be returned
     * @return float  The weight
     */
    public function getWeight($feature)
    {
        if (!isset($this->l[$feature])) return 0;
        else return $this->l[$feature];
    }

    /**
     * Get all the weights as an array.
     *
     * @return array The weights as an associative array
     */
    public function getWeights()
    {
        return $this->l;
    }
}
?>
<?php

/**
 * Maxent is a model that assigns a weight for each feature such that all
 * the weights maximize the Conditional Log Likelihood of the training
 * data. Because it does that without making any assumptions about the data
 * it is named maximum entropy model (maximum ignorance).
 */
class Maxent extends LinearModel
{
    const INITIAL_PARAM_VALUE = 0;

    /**
     * Calculate all the features for every possible class. Pass the
     * information to the optimizer to find the weights that satisfy the
     * constraints and maximize the entropy
     *
     * @param $ff The feature factory
     * @param $tset A collection of training documents
     * @param $opt An optimizer, we need a maxent optimizer
     * @return void
     */
    public function train(FeatureFactoryInterface $ff, TrainingSet $tset, MaxentOptimizerInterface $opt)
    {
        $classSet = $tset->getClassSet();
        $features = $this->calculateFeatureArray($classSet,$tset,$ff);
        $this->l = $opt->optimize($features);
    }

    /**
     * Calculate all the features for each possible class of each
     * document. This is done so that we can optimize without the need
     * of the FeatureFactory.
     *
     * We do not want to use the FeatureFactoryInterface both because it would
     * be slow to calculate the features over and over again, but also
     * because we want to be able to optimize externally to
     * gain speed (PHP is slow!).
     *
     * @param $classes A set of the classes in the training set
     * @param $tset A collection of training documents
     * @param $ff The feature factory
     * @return array An array that contains every feature for every possible class of every document
     */
    protected function calculateFeatureArray(array $classes, TrainingSet $tset, FeatureFactoryInterface $ff)
    {   
        $features = array();
        $tset->setAsKey(TrainingSet::OFFSET_AS_KEY);
        foreach ($tset as $offset=>$doc) {
            $features[$offset] = array();
            foreach ($classes as $class) {
                $features[$offset][$class] = $ff->getFeatureArray($class,$doc);
            }
            $features[$offset]['__label__'] = $doc->getClass();
        }
        
        return $features;
    }

    /**
     * Calculate the probability that document $d belongs to the class
     * $class given a set of possible classes, a feature factory and
     * the model's weights l[i]
     *
     * @param $classes The set of possible classes
     * @param $ff The feature factory
     * @param $d The document
     * @param  string $class A class for which we calculate the probability
     * @return float  The probability that document $d belongs to class $class
     */
    public function P(array $classes,FeatureFactoryInterface $ff,DocumentInterface $d,$class)
    {
        $exps = array();
        foreach ($classes as $cl) {
            $tmp = 0.0;
            foreach ($ff->getFeatureArray($cl,$d) as $i) {
                $tmp += $this->l[$i];
            }
            $exps[$cl] = exp($tmp);
        }

        return $exps[$class]/array_sum($exps);
    }

    /**
     * Not implemented yet.
     * Simply put:
     * 	result += log( $this->P(..., ..., ...) ) for every doc in TrainingSet
     *
     * @throws \Exception
     */
    public function CLogLik(TrainingSet $tset,FeatureFactoryInterface $ff)
    {
        throw new \Exception("Unimplemented");
    }

    /**
     * Simply print_r weights. Usefull for some kind of debugging when
     * working with small training sets and few features
     */
    public function dumpWeights()
    {
        return $this->l;
    }

}
?>


<?php

$morpheme = $_GET['morpheme'];
$num = intval($_GET['id']);
$txt = $_GET['txt'];
// include('porterstemmer.php');
// $word = PorterStemmer::Stem($_POST['word']); 

if ($morpheme == "") {  // if blank, return blank
    echo "";    
}

$xmlDoc = new DOMDocument();
$xmlDoc->load("../phrasicon.xml");
$xpath = new DOMXPath($xmlDoc);
$result = $xpath->query("(//morpheme[m='$morpheme'])");
$resultM = $xpath->query("(//m[text() = '$morpheme'])");

if ($result->length == 0) { // if no morpheme found in existing data, return blank
    echo "";
} else {

$glossTypes = array();
    
foreach($resultM as $entry) { // check if only one gloss

$id = $entry->getAttribute('id');
//echo $id;
$g = $xpath->query("(//g[@id = '$id'])");
$gloss = $g->item(0)->nodeValue;
array_push($glossTypes, $gloss);    
}

$glossTypes = array_values(array_unique($glossTypes));
    
if (sizeof($glossTypes) == 1) {

echo $gloss;

} else {

$morphemes = "";
$glosses = "";
        
foreach($result as $entry) {
    $m = "<s> ";
    $g = "<s> ";
    $length = $entry->childNodes->length;
    for ($x=1; $x<$length-1; $x+=2) {
    $morph = $entry->childNodes->item($x)->nodeValue;
    $id = $entry->childNodes->item($x)->getAttribute('id');
    $gl = $xpath->query("(//g[@id = '$id'])");
    $gloss = $gl->item(0)->nodeValue;
    $m = $m . $morph . " ";  
    $g = $g . $gloss . " ";
    }
    $m = rtrim($m, " ");
    $g = rtrim($g, " ");
    $m .= " </s> ";
    $g .= " </s> ";
    $morphemes = $morphemes . $m;
    $glosses = $glosses . $g;
}
$morphemes = rtrim($morphemes, " ");
$glosses = rtrim($glosses, " ");
$tok = new WhitespaceTokenizer();
$tokG = new WhitespaceTokenizer();

$tokens = $tok->tokenize($morphemes);
$tokensG = $tokG->tokenize($glosses);

//print_r($tokensM);
//echo($tokensG[5]);
    
$tset = new TrainingSet();    
$occ = array();
    
//print_r($glossTypes);
// find out how many glosses, and where they are
$length = sizeof($glossTypes);
for ($x = 0; $x < $length; $x++) {
    $positions = array();
    $gloss = $glossTypes[$x];
    $lengthTokG = sizeof($tokensG);
    for ($y = 0; $y < $lengthTokG; $y++) {
        if ($tokensG[$y] == $gloss && $tokens[$y] == $morpheme) {
            array_push($positions, $y);  
        }
    }
    $occ[] = $positions;
}
    

$count = 0;
array_walk(
$tokens, function ($t,$i) use($tset,$tokens,$occ,$glossTypes,$length,$count) { // function (value, key) 
for($x=0; $x<$length; $x++){
    if (in_array($i, $occ[$x])) { 
        $tset->addDocument($glossTypes[$x], new WordDocument($tokens,$i,1));
    }
}
}
);

// look at one before...
// Remember that in maxent a feature should also target the class
// thus we prepend each feature name with the class name
// $occ[type][$x] - 1 = position of previous words...

// $data[0] is the current word
// $data[1] is an array of previous words
// $data[2] is an array of following words
     
// feature engineering    

$feats = array();

for ($x=0; $x<$length; $x++) {
    $type = $glossTypes[$x];
    $positions = $occ[$x];
    for ($y=0; $y<sizeof($positions); $y++) {    
        $prev = $tokens[$positions[$y] - 1];
        array_push($feats, 
          function ($class, $d) use ($prev) {
              $data = $d->getDocumentData();
              return ($data[1][0] == "$prev") ? "$class ^ prev_ends_with($prev)" : null;
          }       
        );
    }
}
    
$ff = new FunctionFeatures(
$feats
);    
    
    
// instanciate a gradient descent optimizer for maximum entropy
$optimizer = new MaxentGradientDescent(
0.001, // Stop if each weight changes less than 0.001
0.1, // learning rate
10 // maximum iterations
);

// an empty maxent model
$maxent = new Maxent(array());
// train

$maxent->train($ff,$tset,$optimizer);    

// debugging    
//$weights = $maxent->dumpWeights();    
//print_r($weights);

$tok = new WhitespaceTokenizer();

$tokens = $tok->tokenize($txt);

$doc = new WordDocument($tokens, $num, 1);

$classification = array();

for ($x = 0; $x < $length; $x++) {   
    array_push($classification, $maxent->P($glossTypes, $ff, $doc, $glossTypes[$x]));
}

echo $glossTypes[array_search(max($classification), $classification)];
       
}
}   
?>

