<?php
namespace MCDev\IlluminateConnectionEvents\Traits;

use Illuminate\Events\Dispatcher;

trait SupportsEvents
{

    /**
     * The event dispatcher instance.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * Get the event dispatcher used by the object.
     *
     * @return Dispatcher
     */
    public function getEventDispatcher(): Dispatcher
    {
        return $this->events;
    }

    /**
     * Set the event dispatcher instance on the object.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function setEventDispatcher(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Unset the event dispatcher instance on the object.
     *
     * @return void
     */
    public function unsetEventDispatcher()
    {
        $this->events = null;
    }

    /**
     * Check if the object is using events.
     *
     * @return boolean
     */
    public function usingEvents(): bool
    {
        return isset($this->events);
    }

    /**
     * Dispatch the given event for the object.
     *
     * @param object $event
     * @param boolean $halt
     * @return mixed
     */
    protected function fireEvent(object $event, bool $halt = false)
    {
        if (!$this->usingEvents()) {
            return true;
        }

        $method = $halt ? 'until' : 'dispatch';

        return $this->events->$method(get_class($event), $event);
    }
}
