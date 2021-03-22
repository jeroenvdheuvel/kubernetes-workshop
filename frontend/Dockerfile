FROM node:15.12 as build

WORKDIR /usr/src/app

COPY package.json package-lock.json ./

RUN npm install

COPY . ./

RUN npm run build

FROM nginx:1.19 as release

WORKDIR /usr/share/nginx/html/

COPY --from=build /usr/src/app/build/ ./
