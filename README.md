# Kubernetes-workshop

1. Create Kubernetes namespace that will contain your app (should be unique): `kubectl create ns NAMESPACE_NAME_HERE`
2. Change to the created namespace: `kubectl config set-context --current --namespace=NAMESPACE_NAME_HERE`
3. Change the host field in ingress `host: kubernetes-workshop.staging.werkspot.com`. This field should be unique but
   should be a subdomain of staging.werkspot.com. Otherwise, the SSL certificate won't work.
3. Apply Kubernetes configuration: `kubectl apply -f .kubernetes`

When changing ConfigMaps, make sure to recreate all pods that use the new ConfigMap.
This can be done by deleting all pods of the workshop:
`kubectl delete pods -l app.kubernetes.io/part-of=kubernetes-workshop`.
Kubernetes deployments will make sure the pod is recreated after deletion.

When deployed check if it works by going to the defined URL.
Log files of the containers can be tailed like this:
PHP: `kubectl logs -f -l app.kubernetes.io/part-of=kubernetes-workshop -c pi-calculator-php`
Nginx: `kubectl logs -f -l app.kubernetes.io/part-of=kubernetes-workshop -c pi-calculator-nginx`
This command will follow (-f) the logs of all pods with the label `app.kubernetes.io/part-of=kubernetes-workshop` that
match the container name `pi-calculator-php` or `pi-calculator-nginx`. Using labels makes it easier to view logs,
because the labels won't change while pod names will.
