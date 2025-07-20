# AfterSave Behavior

A CakePHP behavior that allows the entity to be available after the save in the state
it was before the save.
It also allows it to be available outside of the afterSave() callback later on, where needed.

## Introduction
It takes a clone of the entity from beforeSave(). This allows all the
info on it to be available in the afterSave() callback or from the outside without resetting (dirty, ...).

This can be useful if one wants to compare what fields got changed, or e.g. for logging the diff.

### Technical limitation
Make sure you do not further modify the entity in the table's beforeSave() then. As this would
not be part of the cloned and stored entity here.

## Usage
Attach it to your model's `Table` class in its `initialize()` method like so:
```php
$this->addBehavior('Tools.AfterSave', $options);
```

Then inside your table you can do:
```php
public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options): void {
    $entityBefore = $this->getEntityBeforeSave();
    // Now you can check diff dirty fields etc
}
```

The same call could also be made from the calling layer/object on the table:
```php
$table->saveOrFail();
$entityBefore = $table->getEntityBeforeSave();
```

If you are using save(), make sure you check the result and that the save was successful.
Only call this method after a successful save operation.
Otherwise, there will not be an entity stored and you would get an exception here.

Also note that by default the "dirty" fields should be present in the afterSave() callback still.
Same for "original" values.
So if your needs are bound to that callback only, this behavior might not be needed usually.
