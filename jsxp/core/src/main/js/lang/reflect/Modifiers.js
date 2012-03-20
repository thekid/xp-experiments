// {{{ Modifiers
lang.reflect.Modifiers = function() {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'lang.reflect.Modifiers';
  }
}

extend(lang.reflect.Modifiers, lang.Object);

Object.defineProperty(lang.reflect.Modifiers, 'STATIC', { value : 1, writeable : false });
// }}}
