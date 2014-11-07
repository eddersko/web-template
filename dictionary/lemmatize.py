import sys
sys.path.append('/home2/northfz2/python/lib/python2.7/site-packages/setuptools-0.6c11-py2.7.egg')
sys.path.append('/home2/northfz2/python/lib/python2.7/site-packages/pip-1.1-py2.7.egg')
sys.path.append('/home2/northfz2/python/lib/python2.7/site-packages/nltk-3.0a3-py2.7.egg')
sys.path.append('/home2/northfz2/python/lib/python2.7/site-packages/PyYAML-3.11-py2.7-linux-x86_64.egg')
sys.path.append('/home2/northfz2/python/lib/python27.zip')
sys.path.append('/home2/northfz2/python/Python-2.7.2/Lib')
sys.path.append('/home2/northfz2/python/Python-2.7.2/Lib/plat-linux3')
sys.path.append('/home2/northfz2/python/Python-2.7.2/Lib/lib-tk')
sys.path.append('/home2/northfz2/python/Python-2.7.2/Lib/lib-old')
sys.path.append('/home2/northfz2/python/Python-2.7.2/build/lib.linux-x86_64-2.7')

import nltk
from nltk.stem.wordnet import WordNetLemmatizer

word = sys.argv[1]
    
word = word.lower()

def get_wordnet_pos(lemmatize):
    n = len(lemmatize)
    lmtzr = WordNetLemmatizer()
    lemma = lmtzr.lemmatize(lemmatize, 'n')
    if len(lemma) < n:
        return lemma
    lemma = lmtzr.lemmatize(lemmatize, 'v')
    if len(lemma) < n:
        return lemma
    lemma = lmtzr.lemmatize(lemmatize, 'a')
    if len(lemma) < n:
        return lemma
    lemma = lmtzr.lemmatize(lemmatize, 'r')
    return lemma

result = get_wordnet_pos(word)

print result
