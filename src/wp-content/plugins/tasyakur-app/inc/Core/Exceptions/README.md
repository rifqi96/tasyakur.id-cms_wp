## namespace: Tasyakur\Core\Exceptions
- A place to put the app Exceptions.
- The exception handler is also under this folder.
- The handler is also a service.
- If you want to create another handler (i.e. another handler library), please make sure to extend the **BaseHandler** (automatically will implement **Tasyakur\Core\Contracts\HandlerInterface**, which also is the abstract class for an exception handler). 