import React, { useState } from 'react';

const App = () => {
    const [pi, setPi] = useState(null);
    const [calculationTime, setCalculationTime] = useState(null);
    const [iterations, setIterations] = useState(null);
    const [isFormSubmitted, setFormSubmitted] = useState(false);

    const onFormSubmit = (e) => {
        e.preventDefault();

        setFormSubmitted(true);

        (async () => {
            let response = null;

            try {
                response = await fetch('/api?iterations=' + iterations);
            } catch (error) {
                alert('Got unexpected error: ' + error);
                return;
            }

            if (response.status !== 200) {
                alert('Got unexpected status code ' + response.status)
                return;
            }

            const serverTiming = response.headers.get('Server-Timing');
            const [, durationString] = serverTiming.match(/dur=(\d+\.\d+)/);
            setCalculationTime(durationString);

            const pi = await response.json();
            setPi(pi);
        })();
    };

    if (isFormSubmitted && pi !== null) {
        return <>
            <h1>PI calculator</h1>
            <p>
                Calculated PI: <strong>{pi}</strong>
                by iterating <strong>{iterations}</strong> times
                in <strong>{calculationTime}</strong> microseconds.
            </p>
        </>;
    } else if (isFormSubmitted && iterations > 0) {
        return <>
            <h1>PI calculator</h1>
            <p>Calculating pi...</p>
        </>;
    }


    return (
        <>
            <h1>PI calculator</h1>
            <form onSubmit={onFormSubmit}>
                <label htmlFor="iterations">Number of iterations to calculate PI</label>
                <input id="iterations" name="iterations" type="number" min="0" max="9223372036854775807" step="1" value={iterations} onChange={e => setIterations(e.target.value)} />
                <button type="submit">Submit</button>
            </form>
        </>
    );
};


export default App;
