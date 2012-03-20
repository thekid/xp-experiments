uses('unittest.AssertionFailedError');

// {{{ TestCase
unittest.TestCase = define('unittest.TestCase', 'lang.Object', function(name) {
  this.name = name;
});

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

unittest.TestCase.prototype._equals = function(a, b) {
  if (null !== a && undefined !== a.__class) {
    return a.equals(b);
  } else if (typeof(a) === 'object') {
    for (var k in a) {
      if (this._equals(a[k], b[k])) continue;
      return false;
    }
    return true;
  }
  return a === b;
}

unittest.TestCase.prototype.assertEquals = function(a, b) {
  if (!this._equals(a, b)) {
    throw new unittest.AssertionFailedError('Expected ' + a + ' but have ' + b);
  }
}

unittest.TestCase.prototype.assertTrue = function(val) {
  this.assertEquals(true, val);
}

unittest.TestCase.prototype.assertFalse = function(val) {
  this.assertEquals(false, val);
}

unittest.TestCase.prototype.assertNull = function(val) {
  this.assertEquals(null, val);
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
