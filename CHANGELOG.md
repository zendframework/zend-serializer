# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.7.1 - 2016-04-18

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#15](https://github.com/zendframework/zend-serializer/pull/15) fixes the
  `Module::init()` method to properly receive a `ModuleManager` instance, and
  not expect a `ModuleEvent`.

## 2.7.0 - 2016-04-06

### Added

- [#14](https://github.com/zendframework/zend-serializer/pull/14) exposes the
  package as a ZF component and/or generic configuration provider, by adding the
  following:
  - `AdapterPluginManagerFactory`, which can be consumed by container-interop /
    zend-servicemanager to create and return a `AdapterPluginManager` instance.
  - `ConfigProvider`, which maps the service `SerializerAdapterManager` to the above
    factory.
  - `Module`, which does the same as `ConfigProvider`, but specifically for
    zend-mvc applications. It also provices a specification to
    `Zend\ModuleManager\Listener\ServiceListener` to allow modules to provide
    serializer configuration.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.6.1 - 2016-02-03

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#13](https://github.com/zendframework/zend-serializer/pull/13) updates the
  zend-stdlib dependency to `^2.7 || ^3.0`, as it can work with either version.

## 2.6.0 - 2016-02-02

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#2](https://github.com/zendframework/zend-serializer/pull/2) updates the component
  to use zend-servicemanager v3. This involves updating the `AdapterPluginManager`
  to follow changes to `Zend\ServiceManager\AbstractPluginManager`, and updating
  the `Serializer` class to inject an empty `ServiceManager` into instances of
  the `AbstractPluginManager` that it creates.
