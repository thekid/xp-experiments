uses('unittest.AssertionFailedError');

// {{{ TestCase
unittest.TestCase = function(name) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'unittest.TestCase';
    this.name = name;
  }
}

unittest.TestCase.prototype= Object.create(lang.Object.prototype);

unittest.TestCase.prototype.name = '';

unittest.TestCase.prototype.getName = function() {
  return this.name;
}

unittest.TestCase.prototype.setUp = function() {
  // Empty
}

unittest.TestCase.prototype.tearDown = function() {
  // Empty
}

unittest.TestCase.prototype.assertEquals = function(a, b) {
  if (null !== a && typeof(a) === 'object') {
    r= a.equals(b);
  } else {
    r= a === b;
  }
  if (!r) {
    throw new unittest.AssertionFailedError('Expected ' + a + ' but have ' + b);
  }
}

unittest.TestCase.prototype.assertInstanceOf = function(type, value) {
  var actual = typeof(value);
  if (actual === 'object') {
    actual = value.getClassName();
  }
  if (actual !== type) {
    throw new unittest.AssertionFailedError('Expected ' + type + ' but have ' + actual);
  }
}
// }}}
