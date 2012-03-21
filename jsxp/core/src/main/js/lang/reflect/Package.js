lang.reflect.Package = define('lang.reflect.Package', 'lang.Object', function Package(name) {
  this.name = name;
});

lang.reflect.Package.prototype.name = '';

lang.reflect.Package.forName = function Package$forName(name) {
  return new lang.reflect.Package(name);
}

lang.reflect.Package.prototype.getName = function Package$getName() {
  return this.name;
}

lang.reflect.Package.prototype.toString = function Package$toString() {
  return this.getClassName() + '<' + this.name + '>';
}

lang.reflect.Package.prototype.equals = function Package$equals(cmp) {
  return cmp instanceof lang.reflect.Package && cmp.name === this.name;
}

lang.reflect.Package.prototype.contentsOf = function Package$contentsOf(package, pattern, result) {
  var contents= [];
  var dir= package.replace(/\./g, global.fs.DIRECTORY_SEPARATOR);

  for (var i= 0; i < global.classpath.length; i++) {
    var files = global.fs.glob(global.classpath[i] + global.fs.DIRECTORY_SEPARATOR + dir, pattern);
    for (var j= 0; j < files.length; j++) {
      contents.push(result(package, dir, files[j]));
    }
  }

  return contents;
}

lang.reflect.Package.prototype.getClassNames = function Package$getClassNames(cmp) {
  return this.contentsOf(this.name, /\.js/, function (package, path, file) { 
    return package + '.' + file.substring(0, file.length - 3); // ".js"
  });
}

lang.reflect.Package.prototype.getClasses = function Package$getClasses(cmp) {
  return this.contentsOf(this.name, /\.js/, function (package, path, file) { 
    return lang.XPClass.forName(package + '.' + file.substring(0, file.length - 3)); // ".js"
  });
}
