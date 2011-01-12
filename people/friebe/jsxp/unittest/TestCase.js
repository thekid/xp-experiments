uses('unittest.AssertionFailedError');

// {{{ TestCase
function TestCase(name) {
  {
    this.__class = 'TestCase';
    this.name = name;
  }
}

TestCase.prototype= new Object();

TestCase.prototype.name = '';

TestCase.prototype.getName = function() {
  return this.name;
}

TestCase.prototype.setUp = function() {
  // Empty
}

TestCase.prototype.tearDown = function() {
  // Empty
}

TestCase.prototype.assertEquals = function(a, b) {
  if (typeof(a) === 'object') {
    r= a.equals(b);
  } else {
    r= a === b;
  }
  if (!r) {
    throw new AssertionFailedError('Expected ' + a + ' but have ' + b);
  }
}

TestCase.prototype.assertInstanceOf = function(type, value) {
  var actual = typeof(value);
  if (actual === 'object') {
    actual = value.getClassName();
  }
  if (actual !== type) {
    throw new AssertionFailedError('Expected ' + type + ' but have ' + actual);
  }
}
// }}}
