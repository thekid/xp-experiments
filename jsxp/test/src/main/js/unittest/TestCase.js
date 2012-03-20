uses('unittest.AssertionFailedError');

// {{{ TestCase
unittest.TestCase = define('unittest.TestCase', 'lang.Object', function TestCase(name) {
  this.name = name;
});

unittest.TestCase.prototype.name = '';

unittest.TestCase.prototype.getName = function TestCase$getName() {
  return this.name;
}

unittest.TestCase.prototype.setUp = function TestCase$setUp() {
  // Empty
}

unittest.TestCase.prototype.tearDown = function TestCase$tearDown() {
  // Empty
}

unittest.TestCase.prototype._equals = function TestCase$_equals(a, b) {
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

unittest.TestCase.prototype.assertEquals = function TestCase$assertEquals(a, b) {
  if (!this._equals(a, b)) {
    throw new unittest.AssertionFailedError('Expected ' + a + ' but have ' + b);
  }
}

unittest.TestCase.prototype.assertNotEquals = function TestCase$assertNotEquals(a, b) {
  if (this._equals(a, b)) {
    throw new unittest.AssertionFailedError('Expected an object unequal to ' + a);
  }
}

unittest.TestCase.prototype.assertTrue = function TestCase$assertTrue(val) {
  this.assertEquals(true, val);
}

unittest.TestCase.prototype.assertFalse = function TestCase$assertFalse(val) {
  this.assertEquals(false, val);
}

unittest.TestCase.prototype.assertNull = function TestCase$assertNull(val) {
  this.assertEquals(null, val);
}

unittest.TestCase.prototype.assertInstanceOf = function TestCase$assertInstanceOf(type, value) {
  var actual = typeof(value);
  if (actual === 'object') {
    actual = value.getClassName();
  }
  if (actual !== type) {
    throw new unittest.AssertionFailedError('Expected ' + type + ' but have ' + actual);
  }
}
// }}}
